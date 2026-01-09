<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'headline_en',
        'headline_ar',
        'paragraph_en',
        'paragraph_ar',
        'linkedin_url',
        'twitter_url',
        'facebook_url',
        'instagram_url',
        'snapchat_url',
        'tiktok_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the active hero section
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Get headline based on current locale
     */
    public function getHeadlineAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->headline_ar : $this->headline_en;
    }

    /**
     * Get paragraph based on current locale
     */
    public function getParagraphAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->paragraph_ar : $this->paragraph_en;
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($heroSection) {
            // If this hero section is being set as active, deactivate all others
            if ($heroSection->is_active) {
                static::where('id', '!=', $heroSection->id)->update(['is_active' => false]);
            }
        });
    }
}
