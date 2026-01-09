<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\RoleDisplayWidget;
use App\Filament\Widgets\StatsOverview;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getWidgets(): array
    {
        return [
            RoleDisplayWidget::class,
            StatsOverview::class,
        ];
    }
}
