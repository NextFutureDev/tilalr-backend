<?php

namespace App\Filament\Resources\ReservationResource\Widgets;

use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReservationStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Reservations', Reservation::count())
                ->description('All time')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('gray'),

            Stat::make('Pending', Reservation::where('status', 'pending')->count())
                ->description('Awaiting action')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Not Contacted', Reservation::where('admin_contacted', false)->count())
                ->description('Need to contact')
                ->descriptionIcon('heroicon-m-phone')
                ->color('danger'),

            Stat::make('This Week', Reservation::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count())
                ->description('New this week')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
