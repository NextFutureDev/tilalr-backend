<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\HasImageCleanup;

class Training extends Model
{
    use HasFactory, HasTranslations, HasImageCleanup;

    protected $fillable = [
        'name',
        'name_ar',
        'short_description',
        'short_description_ar',
        'description',
        'description_ar',
        'icon',
        'image',
        'slug',
    ];

    // Remove translatable since we're using separate columns now
    // public $translatable = ['name', 'description'];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($training) {
            if (empty($training->slug) && !empty($training->name)) {
                $training->slug = str_replace(' ', '-', strtolower(preg_replace('/[^A-Za-z0-9 ]/', '', $training->name)));
            }
        });
    }

    // Accessor for icon URL
    public function getIconUrlAttribute()
    {
        return $this->icon ? asset('storage/' . $this->icon) : null;
    }

    // Accessor for icon path
    public function getIconPathAttribute()
    {
        return $this->icon ? 'storage/' . $this->icon : null;
    }

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // Accessor for image path
    public function getImagePathAttribute()
    {
        return $this->image ? 'storage/' . $this->image : null;
    }

    // Image fields for cleanup trait
    protected function getImageFields(): array
    {
        return ['icon', 'image'];
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }
}
