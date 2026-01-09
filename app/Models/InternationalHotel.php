<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternationalHotel extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'location_en',
        'location_ar',
        'description_en',
        'description_ar',
        'rating',
        'price',
        'image',
        'amenities_en',
        'amenities_ar',
        'active',
    ];

    protected $casts = [
        'amenities_en' => 'array',
        'amenities_ar' => 'array',
        'active' => 'boolean',
        'price' => 'decimal:2',
    ];
}
