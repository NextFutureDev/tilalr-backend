<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\TeamMember;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Contact Messages', ContactMessage::count())
                ->description('Total messages received')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Team Members', TeamMember::count())
                ->description('Active team members')
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
                ->chart([17, 16, 14, 15, 14, 13, 12]),

            Stat::make('Projects', Project::count())
                ->description('Total projects added to the website')
                ->descriptionIcon('heroicon-m-folder')
                ->color('primary')
                ->chart([15, 4, 13, 2, 12, 4, 16]),
        ];
    }
}
