<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasTranslations;

    protected $fillable = [
        'position',
        'position_en',
        'company',
        'company_en',
        'period',
        'period_en',
        'is_current',
        'description',
        'description_en',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * بولت‌های شرح وظایف (هر خط یک بولت)
     */
    public function bullets(): array
    {
        $raw = $this->t('description');

        return collect(preg_split('/\r\n|\r|\n/', $raw))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
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
