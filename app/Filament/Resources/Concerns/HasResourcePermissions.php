<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasResourcePermissions
{
    /**
     * Get the resource permission key
     * Override this in individual resources if needed
     */
    public static function getPermissionKey(): string
    {
        // Convert class name to permission key
        // e.g., TripResource -> trips
        $className = class_basename(static::class);
        $modelName = str_replace('Resource', '', $className);
        return strtolower($modelName) . 's';
    }

    /**
     * Check if current user can view the resource list
     */
    public static function canViewAny(): bool
    {
        $user = auth()->user();
        if (!$user) return false;
        
        // Super admin has all permissions
        if ($user->hasRole('super_admin')) return true;
        
        return $user->hasPermission(static::getPermissionKey() . '.view_any');
    }

    /**
     * Check if current user can view a specific record
     */
    public static function canView(Model $record): bool
    {
        $user = auth()->user();
        if (!$user) return false;
        
        if ($user->hasRole('super_admin')) return true;
        
        return $user->hasPermission(static::getPermissionKey() . '.view');
    }

    /**
     * Check if current user can create new records
     */
    public static function canCreate(): bool
    {
        $user = auth()->user();
        if (!$user) return false;
        
        if ($user->hasRole('super_admin')) return true;
        
        return $user->hasPermission(static::getPermissionKey() . '.create');
    }

    /**
     * Check if current user can edit a record
     */
    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();
        if (!$user) return false;
        
        if ($user->hasRole('super_admin')) return true;
        
        return $user->hasPermission(static::getPermissionKey() . '.update');
    }

    /**
     * Check if current user can delete a record
     */
    public static function canDelete(Model $record): bool
    {
        $user = auth()->user();
        if (!$user) return false;
        
        if ($user->hasRole('super_admin')) return true;
        
        return $user->hasPermission(static::getPermissionKey() . '.delete');
    }

    /**
     * Check if user can access this resource at all
     */
    public static function canAccess(): bool
    {
        return static::canViewAny();
    }
}
