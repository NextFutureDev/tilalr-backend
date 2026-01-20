<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;
use App\Traits\HasImageCleanup;

class TeamMember extends Model
{
    use HasFactory, HasTranslations, HasImageCleanup;

    protected $fillable = [
        'name',
        'bio',
        'image',
        'role_id',
    ];

    public $translatable = ['name', 'bio'];

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

    // Relationships
    public function roleRelation(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
