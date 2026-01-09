<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class RoleDisplayWidget extends Widget
{
    protected static string $view = 'filament.widgets.role-display-widget';

    protected static ?int $sort = -3;

    public function getRoleInfo()
    {
        $user = auth()->user();
        if (!$user) {
            return null;
        }

        $role = $user->roles()->first();
        return [
            'role_name' => $role?->display_name ?? 'No Role Assigned',
            'user_name' => $user->name,
            'permissions_count' => $user->roles()->first()?->permissions()->count() ?? 0,
        ];
    }
}
