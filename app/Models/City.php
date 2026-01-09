<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'images',
        'country', 'order', 'lang', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images' => 'array',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
