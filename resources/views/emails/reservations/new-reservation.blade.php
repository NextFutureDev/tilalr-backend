@component('mail::message')

# 🔔 New Reservation Request

A new reservation request has been submitted and requires your attention.

---

## Customer Information

| Field | Details |
|:------|:--------|
| **Name** | {{ $reservation->name }} |
| **Email** | {{ $reservation->email }} |
| **Phone** | {{ $reservation->phone ?? 'Not provided' }} |

---

## Trip Details

| Field | Details |
|:------|:--------|
| **Trip Type** | {{ ucfirst($reservation->trip_type ?? 'General') }} |
| **Trip Title** | {{ $reservation->trip_title ?? 'Not specified' }} |
| **Preferred Date** | {{ $reservation->preferred_date ? $reservation->preferred_date->format('F d, Y') : 'Flexible' }} |
| **Number of Guests** | {{ $reservation->guests }} |

---

## Additional Notes

{{ $reservation->notes ?? 'No additional notes provided.' }}

---

## Status

**Current Status:** {{ ucfirst($reservation->status) }}

**Submitted:** {{ $reservation->created_at->format('F d, Y \a\t h:i A') }}

---

@component('mail::button', ['url' => url('/admin/reservations/' . $reservation->id . '/edit'), 'color' => 'primary'])
View & Manage Reservation
@endcomponent

@component('mail::panel')
**⚠️ Action Required:** Please contact the customer within 24 hours to confirm availability and discuss next steps.
@endcomponent

---

Thanks,<br>
{{ config('app.name') }} System
@endcomponent
