<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

class ExtendSessionOnLivewireUpdate
{
    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        // Get the request from the event
        $request = app('request');
        
        if ($request->hasSession()) {
            // Extend session lifetime on every request
            $request->session()->put('_last_activity', now()->timestamp);
            
            // Regenerate CSRF token
            $request->session()->regenerateToken();
            
            Log::debug('Livewire Request - Session Extended', [
                'path' => $request->path(),
                'session_id' => $request->session()->getId(),
            ]);
        }
    }
}
