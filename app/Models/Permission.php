<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name', // 'users.view', 'users.create', etc
        'display_name',
        'group',
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

    /**
     * Get permissions grouped by their group name
     */
    public static function getGrouped()
    {
        return static::orderBy('group')->orderBy('name')->get()->groupBy('group');
    }

    /**
     * Create standard CRUD permissions for a resource
     */
    public static function createResourcePermissions(string $resource, string $displayName): array
    {
        $permissions = [];
        $actions = [
            'view_any' => "View All $displayName",
            'view' => "View $displayName",
            'create' => "Create $displayName",
            'update' => "Update $displayName",
            'delete' => "Delete $displayName",
        ];

        foreach ($actions as $action => $display) {
            $permissions[] = static::firstOrCreate(
                ['name' => "{$resource}.{$action}"],
                [
                    'display_name' => $display,
                    'group' => $displayName,
                ]
            );
        }

        return $permissions;
    }



}
