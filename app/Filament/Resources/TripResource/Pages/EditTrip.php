<?php

namespace App\Filament\Resources\TripResource\Pages;

use App\Filament\Resources\TripResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;

class EditTrip extends EditRecord
{
    protected static string $resource = TripResource::class;

    protected function getActions(): array
    {
        $viewAction = Action::make('view')
            ->label('View on site')
            ->url(fn() => $this->getViewUrl())
            ->openUrlInNewTab();

        return [
            $viewAction,
            ...parent::getActions(),
        ];
    }

    protected function getViewUrl(): string
    {
        $record = $this->record;
        $lang = $record->lang ?: 'en';
        $slug = $record->slug;
        $base = env('NEXT_PUBLIC_FRONTEND_URL', 'http://localhost:3000');

        return rtrim($base, '/') . "/{$lang}/trips/{$slug}";
    }
}
