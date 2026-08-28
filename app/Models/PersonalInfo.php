<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasTranslations;

    protected $table = 'personal_infos';

    protected $fillable = [
        'name',
        'name_en',
        'job_title',
        'job_title_en',
        'tagline',
        'tagline_en',
        'bio',
        'bio_en',
        'abilities',
        'abilities_en',
        'email',
        'phone',
        'secondary_phone',
        'website',
        'telegram',
        'birth_date',
        'birth_date_en',
        'city',
        'city_en',
        'avatar_path',
        'cv_path',
    ];

    /**
     * لیست توانمندی‌های کلیدی به‌صورت آرایه (هر خط یک آیتم)
     */
    public function abilitiesList(): array
    {
        $raw = $this->t('abilities');

        return collect(preg_split('/\r\n|\r|\n/', $raw))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * عنوان‌های شغلی برای افکت تایپ (جدا شده با |)
     */
    public function jobTitles(): array
    {
        return collect(explode('|', $this->t('job_title')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
