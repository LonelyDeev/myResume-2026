<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'title_en',
        'category',
        'category_en',
        'client',
        'client_en',
        'url',
        'description',
        'description_en',
        'tech_tags',     // با کاما جدا می‌شود: Laravel, MySQL, Redis
        'image_path',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
    ];

    /**
     * لیست تگ‌های تکنولوژی
     */
    public function techs(): array
    {
        return collect(explode(',', (string) $this->tech_tags))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * حرف اول برای کارت گرادیانی (وقتی تصویر آپلود نشده باشد)
     */
    public function initial(): string
    {
        $title = $this->t('title');

        return mb_strtoupper(mb_substr(trim($title), 0, 1));
    }

    public function excerpt(int $limit = 110): string
    {
        return Str::limit($this->t('description'), $limit);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id', 'desc');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
