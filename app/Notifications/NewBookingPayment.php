<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingPayment extends Notification
{
    use Queueable;

    protected $booking;
    protected $payment;

    public function __construct($booking, $payment = null)
    {
        $this->booking = $booking;
        $this->payment = $payment;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $booking = $this->booking;
        $details = is_array($booking->details) ? $booking->details : json_decode($booking->details, true) ?? [];
        
        $customerName = $booking->user->name ?? $details['user_name'] ?? 'N/A';
        $customerEmail = $booking->user->email ?? $details['user_email'] ?? 'N/A';
        $customerPhone = $details['user_phone'] ?? 'N/A';
        $tripTitle = $details['trip_title'] ?? $booking->trip_slug ?? 'N/A';
        $notes = $details['notes'] ?? 'None';
        
        return (new MailMessage)
            ->subject(' حجز جديد - New Booking #' . $booking->id)
            ->greeting('New Booking Payment Received!')
            ->line('---')
            ->line('**معلومات العميل - Customer Details:**')
            ->line('• الاسم/Name: ' . $customerName)
            ->line('• البريد/Email: ' . $customerEmail)
            ->line('• الجوال/Phone: ' . $customerPhone)
            ->line('---')
            ->line('**تفاصيل الحجز - Booking Details:**')
            ->line('• الرحلة/Trip: ' . $tripTitle)
            ->line('• التاريخ/Date: ' . $booking->date)
            ->line('• عدد الأشخاص/Guests: ' . $booking->guests)
            ->line('• المبلغ/Amount: ' . number_format($booking->amount, 2) . ' SAR')
            ->line('---')
            ->line('**حالة الدفع/Payment Status:** ' . ($this->payment->status ?? 'Initiated'))
            ->line('**رقم الحجز/Booking ID:** #' . $booking->id)
            ->line('---')
            ->line('**ملاحظات/Notes:** ' . $notes)
            ->action('View in Admin Panel', url('/admin/bookings'));
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'amount' => $this->booking->amount,
        ];
    }
}