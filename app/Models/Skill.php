<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasTranslations;

    protected $fillable = [
        'category',
        'category_en',
        'name',
        'name_en',
        'level',        // اگر مقدار داشته باشد به‌صورت نوار پیشرفت نمایش داده می‌شود
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'level'      => 'integer',
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
