<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'image',
        'images', 'category', 'order', 'lang', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images' => 'array',
        'price' => 'decimal:2',
    ];
}
