<?php

namespace App\Filament\Actions;

use App\Models\CustomPaymentOffer;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class CopyPaymentLinkAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'copyLink')
            ->label('Copy Link')
            ->icon('heroicon-o-clipboard-document')
            ->color('info')
            ->requiresConfirmation(false)
            ->action(function (CustomPaymentOffer $record) {
                $frontendUrl = config('app.frontend_url', 'http://localhost:3001');
                $paymentLink = $frontendUrl . '/en/pay-custom-offer/' . $record->unique_link;
                
                // Show notification with the link
                Notification::make()
                    ->title('Payment Link Ready')
                    ->body('Copy from your clipboard: ' . $paymentLink)
                    ->success()
                    ->send();
            })
            ->modalContent(fn(CustomPaymentOffer $record) => view('filament.modals.copy-payment-link', ['record' => $record]))
            ->visible(fn(CustomPaymentOffer $record) => 
                $record->payment_status === 'pending' && 
                (auth()->user()?->hasRole('super_admin') || auth()->user()?->hasPermission('custom_payment_offers.view_payment_link'))
            );
    }
}
