<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IslandDestination extends Model
{
    use HasFactory;

    protected $table = 'island_destinations';

    protected $fillable = [
        'slug',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'highlights_en',
        'highlights_ar',
        'includes_en',
        'includes_ar',
        'itinerary_en',
        'itinerary_ar',
        'location_en',
        'location_ar',
        'duration_en',
        'duration_ar',
        'groupSize_en',
        'groupSize_ar',
        'features_en',
        'features_ar',
        'features',
        'image',
        'price',
        'rating',
        'city_id',
        'type',
        'type_en',
        'type_ar',
        'active',
    ];

    protected $casts = [
        'features' => 'array',
        'features_en' => 'array',
        'features_ar' => 'array',
        'highlights_en' => 'array',
        'highlights_ar' => 'array',
        'includes_en' => 'array',
        'includes_ar' => 'array',
        'price' => 'decimal:2',
        'rating' => 'float',
        'active' => 'boolean',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        // Ensure a unique slug exists on creating/saving to prevent route generation errors
        static::creating(function ($model) {
            if (empty($model->slug) && !empty($model->title_en)) {
                $base = Str::slug($model->title_en);
                $slug = $base;
                $i = 1;
                while (self::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $model->slug = $slug;
            }
        });

        static::saving(function ($model) {
            // If slug somehow emptied before save, regenerate from title_en
            if (empty($model->slug) && !empty($model->title_en)) {
                $base = Str::slug($model->title_en);
                $slug = $base;
                $i = 1;
                while (self::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $model->slug = $slug;
            }
        });
    }
}
