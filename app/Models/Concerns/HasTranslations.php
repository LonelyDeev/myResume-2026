<?php

namespace App\Models\Concerns;

/**
 * تریت پشتیبانی از محتوای دوزبانه (فارسی / انگلیسی)
 *
 * ساختار ستون‌ها:
 *   - ستون اصلی (مثلا title)  => محتوای فارسی
 *   - ستون بعلاوه en_        => محتوای انگلیسی (مثلا title_en)
 *
 * نحوه استفاده در ویوها:
 *   {{ $item->t('title') }}   // مقدار متناسب با زبان جاری + fallback به فارسی
 */
trait HasTranslations
{
    /**
     * دریافت مقدار ستون بر اساس زبان جاری اپلیکیشن.
     * اگر مقدار زبان جاری خالی بود، به‌صورت خودکار از مقدار فارسی استفاده می‌شود.
     */
    public function t(string $field, ?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();

        $column = $locale === 'fa' ? $field : $field.'_'.$locale;

        $value = $this->{$column} ?? null;

        if (trim((string) $value) === '') {
            $value = $this->{$field} ?? '';
        }

        return (string) $value;
    }

    /**
     * آیا برای زبان جاری ترجمه اختصاصی وجود دارد؟
     */
    public function hasTranslation(string $field, ?string $locale = null): bool
    {
        $locale = $locale ?: app()->getLocale();

        if ($locale === 'fa') {
            return trim((string) $this->{$field}) !== '';
        }

        return trim((string) ($this->{$field.'_'.$locale} ?? '')) !== '';
    }
}
