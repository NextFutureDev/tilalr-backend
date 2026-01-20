<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug','image','title_en','title_ar','description_en','description_ar','duration',
        'duration_en','duration_ar','location_en','location_ar','group_size','group_size_en','group_size_ar',
        'discount','price','price_en','price_ar','badge','badge_en','badge_ar','features','features_en','features_ar','highlights','highlights_en','highlights_ar','is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'features_en' => 'array',
        'features_ar' => 'array',
        'highlights' => 'array',
        'highlights_en' => 'array',
        'highlights_ar' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'price_en' => 'decimal:2',
        'price_ar' => 'decimal:2',
    ];
}