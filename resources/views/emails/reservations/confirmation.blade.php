@component('mail::message')

# Thank You for Your Reservation Request! 🎉

Dear {{ $reservation->name }},

We have received your reservation request and our team is excited to assist you.

---

## Your Reservation Details

| | |
|:---|:---|
| **Reference Number** | #{{ $reservation->id }} |
| **Trip Type** | {{ ucfirst($reservation->trip_type ?? 'General') }} |
@if($reservation->trip_title)
| **Trip** | {{ $reservation->trip_title }} |
@endif
| **Preferred Date** | {{ $reservation->preferred_date ? $reservation->preferred_date->format('F d, Y') : 'Flexible' }} |
| **Number of Guests** | {{ $reservation->guests }} |
| **Submitted On** | {{ $reservation->created_at->format('F d, Y \a\t h:i A') }} |

---

@component('mail::panel')
## ⚠️ Important Notice

**This is a reservation request only, not a confirmed booking.**

Our team will contact you within **24 hours** to:
- Confirm availability for your requested date
- Discuss trip details and customization options
- Provide pricing information
- Guide you through the booking process if you wish to proceed
@endcomponent

---

## What Happens Next?

1. ✅ **Reservation Received** - We have your request
2. 📞 **We Contact You** - Within 24 hours
3. 💬 **Discuss Details** - Finalize your trip requirements
4. 📝 **Confirm Booking** - Complete payment when ready

---

## Contact Us

If you have any urgent questions, feel free to reach out:

- **Email:** info@tilrimal.com
- **Phone:** +966 XX XXX XXXX

---

@component('mail::subcopy')
Save your reference number **#{{ $reservation->id }}** to track your reservation status.
@endcomponent

Thank you for choosing us for your travel experience!

Warm regards,<br>
**{{ config('app.name') }} Team**
@endcomponent
