<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'name', // 'executive_manager', 'consultant', 'administration'
        'display_name', // 'Executive Manager'
        'description',
        'title_en', // legacy
        'title_ar', // legacy
        'description_en', // legacy
        'description_ar', // legacy
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Relationship: Role has many users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')
            ->withTimestamps();
    }

    /**
     * Relationship: Role has many permissions
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role')
            ->withTimestamps();
    }

    /**
     * Check if role has permission
     */
    public function hasPermission($permission): bool
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }
        return $this->permissions()->where('permissions.id', $permission->id)->exists();
    }

    /**
     * Get the title based on current locale (legacy)
     */
    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"};
    }

    /**
     * Get the description based on current locale
     */
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"description_{$locale}"};
    }

    /**
     * Get team members for this role
     */
    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    /**
     * Scope to get active roles
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title_en');
    }
}
