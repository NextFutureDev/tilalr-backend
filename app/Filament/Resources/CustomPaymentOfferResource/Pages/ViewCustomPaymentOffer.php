<?php

namespace App\Filament\Resources\CustomPaymentOfferResource\Pages;

use App\Filament\Resources\CustomPaymentOfferResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Notifications\Notification;

class ViewCustomPaymentOffer extends ViewRecord
{
    protected static string $resource = CustomPaymentOfferResource::class;

    public function getTitle(): string
    {
        return 'Payment Offer: ' . $this->record->customer_name;
    }

    public function infolist(Infolist $infolist): Infolist
    {
        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
        $paymentLink = $frontendUrl . '/en/pay-custom-offer/' . $this->record->unique_link;

        return $infolist
            ->schema([
                Section::make('Customer Information')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('customer_name')
                                    ->label('Customer Name')
                                    ->weight('bold')
                                    ->size('lg'),
                                TextEntry::make('customer_email')
                                    ->label('Email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable(),
                                TextEntry::make('customer_phone')
                                    ->label('Phone')
                                    ->icon('heroicon-o-phone')
                                    ->copyable(),
                            ]),
                    ]),

                Section::make('Payment Details')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('amount')
                                    ->label('Amount')
                                    ->money('SAR')
                                    ->size('lg')
                                    ->weight('bold')
                                    ->color('success'),
                                TextEntry::make('payment_status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn(string $state) => match ($state) {
                                        'pending' => 'warning',
                                        'paid', 'completed' => 'success',
                                        'failed' => 'danger',
                                        'cancelled' => 'gray',
                                        default => 'gray',
                                    }),
                            ]),
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Payment Link')
                    ->icon('heroicon-o-link')
                    ->description('Share this link with the customer via WhatsApp, Email, or SMS')
                    ->schema([
                        TextEntry::make('unique_link')
                            ->label('Payment URL')
                            ->state($paymentLink)
                            ->copyable()
                            ->copyMessage('Payment link copied!')
                            ->copyMessageDuration(1500)
                            ->url($paymentLink, shouldOpenInNewTab: true)
                            ->color('primary'),
                    ])
                    ->visible(fn() => $this->record->payment_status === 'pending'),

                Section::make('Transaction Details')
                    ->icon('heroicon-o-document-check')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('moyasar_transaction_id')
                                    ->label('Moyasar Transaction ID')
                                    ->copyable()
                                    ->placeholder('Not available yet'),
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('M d, Y H:i:s'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('creator.name')
                                    ->label('Created By'),
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('M d, Y H:i:s'),
                            ]),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
        $paymentLink = $frontendUrl . '/en/pay-custom-offer/' . $this->record->unique_link;
        
        return [
            Actions\Action::make('copyLink')
                ->label('Copy Payment Link')
                ->icon('heroicon-o-clipboard-document')
                ->color('info')
                ->action(function () use ($paymentLink) {
                    Notification::make()
                        ->title('Payment Link Copied!')
                        ->body('The payment link has been copied to your clipboard.')
                        ->success()
                        ->send();
                })
                ->extraAttributes([
                    'onclick' => "navigator.clipboard.writeText('" . addslashes($paymentLink) . "'); return false;",
                ])
                ->visible(fn() => $this->record->payment_status === 'pending'),
                
            Actions\Action::make('openLink')
                ->label('Open Payment Page')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url($paymentLink, shouldOpenInNewTab: true)
                ->visible(fn() => $this->record->payment_status === 'pending'),
                
            Actions\DeleteAction::make()
                ->visible(fn() => $this->record->payment_status === 'pending'),
        ];
    }
}
