<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternationalPackage extends Model
{
    protected $fillable = [
        'type_en',
        'type_ar',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'image',
        'duration_en',
        'duration_ar',
        'price',
        'discount',
        'features_en',
        'features_ar',
        'highlight_en',
        'highlight_ar',
        'active',
    ];

    protected $casts = [
        'features_en' => 'array',
        'features_ar' => 'array',
        'active' => 'boolean',
        'price' => 'decimal:2',
    ];
}
