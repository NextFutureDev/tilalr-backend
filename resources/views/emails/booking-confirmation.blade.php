@component('mail::message')

# Booking Confirmed! 🎉

Dear {{ $booking->details['name'] ?? 'Valued Customer' }},

Your booking has been confirmed. Below are your booking details:

---

## Booking Information

| | |
|:---|:---|
| **Booking ID** | #{{ $booking->id }} |
| **Trip** | {{ $booking->details['trip_title'] ?? 'N/A' }} |
| **Date** | {{ $booking->date ? $booking->date->format('F d, Y') : 'TBD' }} |
| **Number of Guests** | {{ $booking->guests }} |
| **Amount** | {{ isset($booking->details['amount']) ? number_format($booking->details['amount'], 2) . ' SAR' : 'TBD' }} |
| **Status** | {{ ucfirst($booking->status) }} |
| **Payment Status** | {{ ucfirst($booking->payment_status) }} |

---

## What's Next?

@if($booking->payment_status === 'pending')
1. ⏳ **Complete Payment** - Please complete your payment to finalize your booking
2. 📧 **Confirmation** - You'll receive a payment confirmation once processed
3. 📞 **We'll Contact You** - Our team will reach out with trip details
@else
1. ✅ **Payment Received** - Your payment has been processed
2. 📞 **Confirmation Call** - Our team will contact you shortly
3. 🎒 **Get Ready** - Prepare for your amazing trip!
@endif

---

## Contact Us

If you have any questions about your booking:

- **Email:** info@tilrimal.com
- **Phone:** +966 XX XXX XXXX

---

@component('mail::button', ['url' => url('/dashboard?tab=bookings'), 'color' => 'primary'])
View My Bookings
@endcomponent

Thank you for choosing us for your travel experience!

Warm regards,<br>
**{{ config('app.name') }} Team**
@endcomponent
