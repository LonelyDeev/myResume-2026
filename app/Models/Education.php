<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasTranslations;

    protected $table = 'educations';
    protected $fillable = [
        'degree',
        'degree_en',
        'institution',
        'institution_en',
        'period',
        'period_en',
        'description',
        'description_en',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
