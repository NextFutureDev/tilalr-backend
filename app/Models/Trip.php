<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'content', 'price', 'duration',
        'image', 'video', 'images', 'highlights', 'group_size', 'type', 'city_id', 'city_name', 'start_date', 'end_date',
        'order', 'lang', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images' => 'array',
        'highlights' => 'array',
        'price' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'title_trans' => 'array',
        'description_trans' => 'array',
        'content_trans' => 'array',
    ];

    // Helper to get localized value from translation arrays
    public function localized(string $field, string $lang = 'en')
    {
        // field: 'title' | 'description' | 'content'
        $transKey = $field . '_trans';
        $trans = $this->{$transKey} ?? null;

        if (is_array($trans) && isset($trans[$lang]) && $trans[$lang]) {
            return $trans[$lang];
        }

        // fallback: if trip.lang matches requested lang, use main field
        if ($this->lang === $lang && isset($this->{$field}) && $this->{$field}) {
            return $this->{$field};
        }

        // fallback to english main field or first available
        if (isset($this->title) && $field === 'title') return $this->title;
        if (isset($this->description) && $field === 'description') return $this->description;
        if (isset($this->content) && $field === 'content') return $this->content;

        return null;
    }

    protected static function booted()
    {
        static::saving(function (Trip $trip) {
            // Ensure legacy `title` stays in sync with title_trans['en'] when available
            if (is_array($trip->title_trans) && !empty($trip->title_trans['en'])) {
                $trip->title = $trip->title_trans['en'];
            }
            
            // Also sync description legacy for compatibility
            if (is_array($trip->description_trans) && !empty($trip->description_trans['en'])) {
                $trip->description = $trip->description_trans['en'];
            }
        });
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
