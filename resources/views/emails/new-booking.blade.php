@component('mail::message')

# 🔔 New Booking Received

A new booking has been made and requires your attention.

---

## Customer Information

| Field | Details |
|:------|:--------|
| **Name** | {{ $booking->details['name'] ?? 'N/A' }} |
| **Email** | {{ $booking->details['email'] ?? 'N/A' }} |
| **Phone** | {{ $booking->details['phone'] ?? 'Not provided' }} |

---

## Booking Details

| Field | Details |
|:------|:--------|
| **Booking ID** | #{{ $booking->id }} |
| **Trip** | {{ $booking->details['trip_title'] ?? 'N/A' }} |
| **Date** | {{ $booking->date ? $booking->date->format('F d, Y') : 'TBD' }} |
| **Guests** | {{ $booking->guests }} |
| **Amount** | {{ isset($booking->details['amount']) ? number_format($booking->details['amount'], 2) . ' SAR' : 'N/A' }} |
| **Payment Method** | {{ ucfirst(str_replace('_', ' ', $booking->details['payment_method'] ?? 'N/A')) }} |

---

## Status

| Status Type | Value |
|:------------|:------|
| **Booking Status** | {{ ucfirst($booking->status) }} |
| **Payment Status** | {{ ucfirst($booking->payment_status) }} |

---

**Submitted:** {{ $booking->created_at->format('F d, Y \a\t h:i A') }}

@component('mail::button', ['url' => url('/admin/bookings/' . $booking->id . '/edit'), 'color' => 'primary'])
View & Manage Booking
@endcomponent

@if($booking->payment_status === 'pending')
@component('mail::panel')
**⚠️ Action Required:** Payment is pending. Please verify payment status and update accordingly.
@endcomponent
@endif

---

Thanks,<br>
{{ config('app.name') }} System
@endcomponent