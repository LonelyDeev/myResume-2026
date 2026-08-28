<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

/**
 * تنظیمات سایت — رکورد تکی (id = 1)
 */
class Setting extends Model
{
    use HasTranslations;

    protected $fillable = [
        'site_title',
        'site_title_en',
        'meta_description',
        'meta_description_en',
        'footer_text',
        'footer_text_en',
        'contact_intro',
        'contact_intro_en',
        'show_about',
        'show_experience',
        'show_education',
        'show_skills',
        'show_portfolios',
        'show_testimonials',
        'show_contact',
    ];

    protected $casts = [
        'show_about'        => 'boolean',
        'show_experience'   => 'boolean',
        'show_education'    => 'boolean',
        'show_skills'       => 'boolean',
        'show_portfolios'   => 'boolean',
        'show_testimonials' => 'boolean',
        'show_contact'      => 'boolean',
    ];

    /**
     * دریافت رکورد تنظیمات (با مقدار پیش‌فرض در صورت نبود رکورد)
     */
    public static function current(): self
    {
        return static::first() ?? new static([
            'site_title'        => config('app.name'),
            'show_about'        => true,
            'show_experience'   => true,
            'show_education'    => true,
            'show_skills'       => true,
            'show_portfolios'   => true,
            'show_testimonials' => true,
            'show_contact'      => true,
        ]);
    }
}
