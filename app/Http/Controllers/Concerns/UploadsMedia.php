<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadsMedia
{
    /** کیفیت WebP — ۸۵ = بدون افت محسوس */
    protected int $webpQuality = 85;

    /** بیشترین ضلع تصویر؛ بزرگ‌تر فقط کوچک می‌شود (null = بدون محدودیت) */
    protected ?int $maxImageDimension = 2560;

    // ═══════════════ متدهای عمومی تریت ═══════════════

    protected function uploadMedia(?UploadedFile $file, string $directory, ?string $oldPath = null): ?string
    {
        if (! $file) {
            return $oldPath;
        }

        $this->deleteMedia($oldPath);

        return $this->storeOptimized($file, $directory);
    }

    protected function uploadGallery(Request $request, string $field = 'gallery', string $directory = 'gallery', array $oldPaths = []): array
    {
        foreach ($oldPaths as $path) {
            $this->deleteMedia($path);
        }

        $paths = [];

        foreach ((array) $request->file($field, []) as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $path = $this->storeOptimized($file, $directory);
                if ($path !== null) {
                    $paths[] = $path;
                }
            }
        }

        return $paths;
    }

    protected function deleteMedia(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    // ═══════════════ هستهٔ ذخیره و تبدیل ═══════════════

    protected function storeOptimized(UploadedFile $file, string $directory): ?string
    {
        $directory = trim($directory, '/');
        $mimeType  = (string) $file->getMimeType();

        // GIF یا فایل غیرتصویری؟ دست نزن. GD/Imagick بدون WebP؟ دست نزن.
        if (! in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'], true) || ! $this->canConvertToWebp()) {
            return $file->store($directory, 'public') ?: null;
        }

        $source = $file->getRealPath();
        $tmp    = (string) tempnam(sys_get_temp_dir(), 'webp');

        try {
            if (! $this->convertToWebp($source, $tmp)) {
                return $file->store($directory, 'public') ?: null;
            }

            // اگر WebP از فایل اصلی بزرگ‌تر شد، فایل اصلی را نگه می‌داریم
            if ((int) @filesize($tmp) === 0 || @filesize($tmp) >= (int) @filesize($source)) {
                return $file->store($directory, 'public') ?: null;
            }

            $target = $directory . '/' . Str::random(32) . '.webp';

            Storage::disk('public')->put($target, (string) file_get_contents($tmp));

            return $target;
        } finally {
            @unlink($tmp);
        }
    }

    protected function canConvertToWebp(): bool
    {
        if (extension_loaded('imagick')) {
            try {
                if (\Imagick::queryFormats('WEBP')) {
                    return true;
                }
            } catch (\Throwable) {
                // می‌افتیم سراغ GD
            }
        }

        return extension_loaded('gd') && function_exists('imagewebp');
    }

    protected function convertToWebp(string $source, string $target): bool
    {
        // ─── ۱) Imagick (اگر موجود باشد — کیفیت بهتر) ───
        if (extension_loaded('imagick')) {
            try {
                $imagick = new \Imagick($source);
                $imagick->setImageFormat('webp');
                $imagick->setOption('webp:method', '6');
                $imagick->setImageCompressionQuality($this->webpQuality);

                if ($this->maxImageDimension
                    && max($imagick->getImageWidth(), $imagick->getImageHeight()) > $this->maxImageDimension) {
                    $imagick->thumbnailImage($this->maxImageDimension, $this->maxImageDimension, true);
                }

                file_put_contents($target, (string) $imagick->getImageBlob());
                $imagick->clear();

                return true;
            } catch (\Throwable) {
                // می‌افتیم سراغ GD
            }
        }

        // ─── ۲) GD ───
        if (! function_exists('imagewebp')) {
            return false;
        }

        $info = @getimagesize($source);
        if ($info === false) {
            return false;
        }

        [$width, $height, $type] = $info;

        $image = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($source),
            IMAGETYPE_PNG  => @imagecreatefrompng($source),
            IMAGETYPE_WEBP => @imagecreatefromwebp($source),
            default        => false,
        };

        if (! $image) {
            return false;
        }

        // چرخش عکس‌های موبایل بر اساس EXIF
        if ($type === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $exif        = @exif_read_data($source);
            $orientation = (int) ($exif['Orientation'] ?? 1);

            $degrees = match ($orientation) {
                3       => 180,
                6       => -90,
                8       => 90,
                default => 0,
            };

            if ($degrees !== 0) {
                $rotated = imagerotate($image, $degrees, 0);
                imagedestroy($image);
                $image = $rotated;
            }
        }

        // رفع باگ شناخته‌شدهٔ imagewebp با تصاویر پالتی
        if (function_exists('imageistruecolor') && ! imageistruecolor($image)) {
            imagepalettetruecolor($image);
        }

        // کوچک‌سازی در صورت عبور از سقف ابعاد
        $width  = imagesx($image);
        $height = imagesy($image);
        $max    = $this->maxImageDimension;

        if ($max && max($width, $height) > $max) {
            $scale = $max / max($width, $height);
            $newW  = max(1, (int) round($width * $scale));
            $newH  = max(1, (int) round($height * $scale));

            $resized = imagecreatetruecolor($newW, $newH);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newW, $newH, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        // حفظ شفافیت PNG
        imagealphablending($image, false);
        imagesavealpha($image, true);

        $ok = imagewebp($image, $target, $this->webpQuality);
        imagedestroy($image);

        return $ok;
    }
}
