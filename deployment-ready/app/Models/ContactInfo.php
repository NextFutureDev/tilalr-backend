<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContactInfo extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'type',
        'title',
        'content',
        'icon',
        'working_hours',
        'sort_order',
        'is_active',
    ];

    public $translatable = ['title', 'content'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
