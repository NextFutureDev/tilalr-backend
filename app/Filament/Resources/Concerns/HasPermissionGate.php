<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Support\Str;

trait HasPermissionGate
{
    /**
     * Default Filament resource access: Super Admin always has access.
     * Other users must have the appropriate "view_..." or "manage_..." permission
     * for the underlying resource (convention: plural snake-case model name).
     */
    public static function canAccess(): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        // Super Admin or legacy admin flag can access everything
        if ($user->is_admin || $user->hasRole('super_admin') || $user->hasRole('Super Admin')) {
            return true;
        }

        // Determine module name: prefer navigation label/group, else derive from model
        if (isset(static::$navigationLabel) && static::$navigationLabel) {
            $module = static::$navigationLabel;
        } elseif (isset(static::$navigationGroup) && static::$navigationGroup) {
            $module = static::$navigationGroup;
        } else {
            $model = static::getModel();
            $module = $model ? Str::plural(class_basename($model)) : Str::plural(class_basename(static::class));
        }

        return $user->canAccessModule($module);
    }
}
