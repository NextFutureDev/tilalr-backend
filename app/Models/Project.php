<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\HasImageCleanup;

class Project extends Model
{
    use HasFactory, HasTranslations, HasImageCleanup;

    protected $fillable = [
        'name',
        'description',
        'image',
        'project_date',
        'slug',
        'is_featured',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'project_date' => 'date',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = \Str::slug($project->name);
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('name') && empty($project->slug)) {
                $project->slug = \Str::slug($project->name);
            }
        });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
