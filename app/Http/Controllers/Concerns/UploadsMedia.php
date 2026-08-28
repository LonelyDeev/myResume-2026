<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * آپلود و حذف فایل‌های رسانه‌ای (تصویر آواتار، تصویر نمونه‌کار، فایل رزومه و ...)
 * همه فایل‌ها در storage/app/public ذخیره می‌شوند (نیاز به php artisan storage:link دارد)
 */
trait UploadsMedia
{
    protected function uploadMedia(?UploadedFile $file, string $directory, ?string $oldPath = null): ?string
    {
        if (! $file) {
            return $oldPath;
        }

        $this->deleteMedia($oldPath);

        return $file->store($directory, 'public');
    }

    protected function deleteMedia(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
