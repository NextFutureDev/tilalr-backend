<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

class AdminNotifiable
{
    use Notifiable;

    protected $email;

    public function __construct()
    {
        $this->email = config('app.admin_email', 'info@tilalr.com');
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    /**
     * Get the first admin (static factory method)
     */
    public static function first()
    {
        return new self();
    }
}