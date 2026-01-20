<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Support\Str;

trait CanAccessByModule
{
    /**
     * Check if user can access this resource based on their role's module permissions.
     * Determine module name from resource class or model.
     */
    public static function canAccess(): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        // Super Admin always has access
        if ($user->is_admin || $user->hasRole('Super Admin')) {
            return true;
        }

        // Get the module name from the resource (using navigation label or derived from class)
        $module = static::getModuleName();

        return $user->canAccessModule($module);
    }

    /**
     * Get the module name for this resource.
     * Override in specific resources if the auto-detection doesn't work.
     */
    protected static function getModuleName(): ?string
    {
        // Use navigationLabel if set
        if (isset(static::$navigationLabel)) {
            return static::$navigationLabel;
        }

        // Use navigationGroup if set
        if (isset(static::$navigationGroup)) {
            return static::$navigationGroup;
        }

        // Fallback: derive from model
        if (method_exists(static::class, 'getModel')) {
            $model = static::getModel();
            return $model ? Str::plural(class_basename($model)) : null;
        }

        return null;
    }
}
