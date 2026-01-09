<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name', // 'view_international_destinations', 'create_island_destinations', etc
        'display_name',
        'description',
    ];

    /**
     * Relationship: Permission belongs to many roles
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role')
            ->withTimestamps();
    }
}
