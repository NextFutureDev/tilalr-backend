<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Trip;
use App\Models\Offer;
use App\Models\IslandDestination;
use App\Models\InternationalDestination;
use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([3, 4, 5, 5, 6, 6, 6]),

            Stat::make('Trips', Trip::count())
                ->description('Active trips available')
                ->descriptionIcon('heroicon-m-map')
                ->color('info')
                ->chart([2, 3, 4, 5, 5, 6, 6]),

            Stat::make('Offers', Offer::count())
                ->description('Special offers')
                ->descriptionIcon('heroicon-m-gift')
                ->color('warning')
                ->chart([1, 2, 2, 3, 3, 3, 3]),

            Stat::make('Island Destinations', IslandDestination::count())
                ->description('Local island destinations')
                ->descriptionIcon('heroicon-m-sun')
                ->color('primary')
                ->chart([2, 3, 4, 5, 5, 6, 6]),

            Stat::make('International Destinations', InternationalDestination::count())
                ->description('International travel packages')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('danger')
                ->chart([2, 3, 4, 5, 5, 6, 6]),

            Stat::make('Reservations', Reservation::count())
                ->description('Total bookings')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('gray')
                ->chart([0, 0, 0, 0, 0, 0, 0]),
        ];
    }
}
