<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\HasImageCleanup;

class Service extends Model
{
    use HasFactory, HasTranslations, HasImageCleanup;

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'icon',
        'slug',
    ];

    public $translatable = ['name', 'description', 'short_description'];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($service) {
            if (empty($service->slug) && !empty($service->name)) {
                $service->slug = str_replace(' ', '-', strtolower(preg_replace('/[^A-Za-z0-9 ]/', '', $service->name)));
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
}
