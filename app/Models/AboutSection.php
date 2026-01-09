<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'title_en',
        'title_ar',
        'paragraph_en',
        'paragraph_ar',
        'mission_title_en',
        'mission_title_ar',
        'mission_paragraph_en',
        'mission_paragraph_ar',
        'vision_title_en',
        'vision_title_ar',
        'vision_paragraph_en',
        'vision_paragraph_ar',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the title based on current locale
     */
    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"};
    }

    /**
     * Get the paragraph based on current locale
     */
    public function getParagraphAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"paragraph_{$locale}"};
    }

    /**
     * Get the mission title based on current locale
     */
    public function getMissionTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"mission_title_{$locale}"};
    }

    /**
     * Get the mission paragraph based on current locale
     */
    public function getMissionParagraphAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"mission_paragraph_{$locale}"};
    }

    /**
     * Get the vision title based on current locale
     */
    public function getVisionTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"vision_title_{$locale}"};
    }

    /**
     * Get the vision paragraph based on current locale
     */
    public function getVisionParagraphAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"vision_paragraph_{$locale}"};
    }

    /**
     * Scope to get active about section
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
