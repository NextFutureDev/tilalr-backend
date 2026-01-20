# Reservations to Bookings Workflow

## Overview

The system now implements a **two-stage booking workflow** to separate pending reservations from confirmed bookings:

1. **RESERVATION**: Submitted by guest (no payment required yet) → Shows to admin only
2. **BOOKING**: Created when admin converts reservation + payment confirmed → Shows to user in dashboard

---

## Workflow Diagram

```
User submits reservation
         ↓
    POST /api/bookings/guest
         ↓
  Reservation created (status='pending')
         ↓
  Shows in admin panel: "Reservations & Bookings" → "Reservations" tab
         ↓
  Admin reviews and contacts customer
         ↓
  Admin clicks "Convert to Booking" button
         ↓
  Booking created + Reservation marked as 'converted'
         ↓
  User logs in with their email
         ↓
  Sees booking in dashboard / Reservations & Bookings
         ↓
  User pays via payment portal
         ↓
  Booking status: confirmed/paid
```

---

## Database Schema

### Reservations Table
```sql
CREATE TABLE reservations (
  id BIGINT PRIMARY KEY
  name VARCHAR(255) -- Customer name
  email VARCHAR(255) -- Customer email (indexed)
  phone VARCHAR(20)
  trip_type VARCHAR(50) -- activity, hotel, flight, package
  trip_slug VARCHAR(255)
  trip_title VARCHAR(255)
  preferred_date DATE
  guests INT
  details JSON -- Full booking details stored as JSON
  status ENUM('pending', 'contacted', 'confirmed', 'converted', 'cancelled') -- DEFAULT 'pending'
  admin_contacted BOOLEAN -- Has admin contacted customer?
  contacted_at TIMESTAMP
  admin_notes TEXT
  converted_booking_id BIGINT -- Links to booking table when converted
  created_at TIMESTAMP
  updated_at TIMESTAMP
  
  KEY email_idx (email)
  KEY status_idx (status)
  KEY created_at_idx (created_at)
)
```

### Bookings Table
```sql
CREATE TABLE bookings (
  id BIGINT PRIMARY KEY
  user_id BIGINT NULLABLE -- NULL for guest bookings
  service_id BIGINT NULLABLE
  date DATE
  guests INT
  details JSON -- Contains email, phone, trip details
  status ENUM('pending', 'confirmed', 'cancelled') -- DEFAULT 'pending'
  payment_status ENUM('pending', 'paid', 'failed') -- DEFAULT 'pending'
  created_at TIMESTAMP
  updated_at TIMESTAMP
  
  KEY user_id_idx (user_id)
  KEY service_id_idx (service_id)
)
```

---

## API Endpoints

### Public Endpoints (No Authentication)

#### 1. Submit New Reservation
```
POST /api/bookings/guest
Content-Type: application/json

{
  "name": "Ahmed Al-Rashid",
  "email": "ahmed@example.com",
  "phone": "+966501234567",
  "trip_slug": "desert-safari",
  "trip_title": "Desert Safari Experience",
  "trip_type": "activity",  // NEW: activity, hotel, flight, or package
  "date": "2026-02-15",
  "guests": 4,
  "details": {
    "location": "Riyadh",
    "activities": ["camel_riding", "dune_bashing"]
  }
}

Response (201 Created):
{
  "reservation": {
    "id": 5,
    "email": "ahmed@example.com",
    "status": "pending",
    "name": "Ahmed Al-Rashid"
  },
  "message": "Reservation submitted successfully. Admin will contact you to confirm details."
}
```

#### 2. Check Reservation Status (by Email + ID)
```
POST /api/reservations/check-status
Content-Type: application/json

{
  "email": "ahmed@example.com",
  "reservation_id": 5
}

Response:
{
  "success": true,
  "reservation": {
    "id": 5,
    "status": "contacted",        // pending, contacted, confirmed, converted, cancelled
    "trip_title": "Desert Safari Experience",
    "preferred_date": "2026-02-15",
    "guests": 4,
    "created_at": "2025-01-15T10:30:00Z",
    "admin_contacted": true
  }
}
```

### Authenticated User Endpoints

#### 3. Get My Reservations (by logged-in email)
```
GET /api/my-reservations
Authorization: Bearer {token}

Response:
{
  "success": true,
  "reservations": [
    {
      "id": 5,
      "name": "Ahmed Al-Rashid",
      "email": "ahmed@example.com",
      "trip_title": "Desert Safari Experience",
      "trip_type": "activity",
      "status": "contacted",
      "preferred_date": "2026-02-15",
      "guests": 4,
      "admin_contacted": true,
      "converted_booking_id": null,  // Will be filled when converted
      "created_at": "2025-01-15T10:30:00Z"
    }
  ]
}
```

#### 4. Get My Bookings (Authenticated)
```
GET /api/bookings
Authorization: Bearer {token}

Response:
{
  "bookings": [
    {
      "id": 8,
      "user_id": null,
      "date": "2026-02-15",
      "guests": 4,
      "status": "pending",
      "payment_status": "pending",
      "details": {
        "name": "Ahmed Al-Rashid",
        "email": "ahmed@example.com",
        "trip_title": "Desert Safari Experience",
        "converted_from_reservation": 5
      },
      "created_at": "2025-01-15T11:00:00Z"
    }
  ]
}
```

### Admin-Only Endpoints

#### 5. Get All Reservations (Admin)
```
GET /api/admin/reservations?status=pending&contacted=false
Authorization: Bearer {token}
```

#### 6. Mark Reservation as Contacted (Admin)
```
POST /api/admin/reservations/{id}/mark-contacted
Authorization: Bearer {token}
```

#### 7. Convert Reservation to Booking (Admin - Via Filament UI)
**Note:** This is done through Filament Admin Panel UI

- Navigate to "Reservations & Bookings" → "Reservations"
- Click on a pending reservation
- Click "Convert to Booking" button
- Enter the booking amount (SAR)
- Confirm

This will:
1. Create a new `Booking` record with the reservation details
2. Mark the reservation as `status='converted'` and store `converted_booking_id`
3. Customer can now see the booking in their dashboard

---

## Frontend Implementation

### Booking Submission Flow

#### 1. User Submits Reservation
```javascript
// components/IslandDestinations/BookingModal.js

const payload = {
  name: formData.name,
  email: formData.userEmail,
  phone: formData.phoneNumber,
  date: formData.checkInDate,
  guests: formData.numberOfGuests,
  trip_slug: destination?.slug,
  trip_title: destination?.title,
  trip_type: bookingType,  // 'activity', 'hotel', 'flight', or 'package'
  details: bookingData
};

const result = await bookingsAPI.createGuest(payload);
// User redirected to confirmation page
```

#### 2. Confirmation Pages

**Local Activities Reservation:**
```
URL: /[lang]/bookings/local
Message: "Local Activities Reservation Received"
"Thank you! Your reservation request has been submitted. We will review it and 
contact you within 24 hours to confirm the details of your local activities."
```

**International Booking Reservation:**
```
URL: /lang]/bookings/international
Message: "International Booking Reservation Received"
"Thank you! Your reservation request has been submitted. Our team will review it 
and contact you within 24 hours."
```

#### 3. User Dashboard

When user logs in:
1. Dashboard calls `GET /api/bookings` (authenticated)
2. Shows bookings where `user_id = user.id` OR `details->email = user.email`
3. Only shows CONFIRMED bookings (reservations are not shown, they're pending)
4. Can also call `GET /api/my-reservations` to see pending reservation requests

---

## Admin Workflow (Filament Panel)

### Step 1: Review Pending Reservations
```
URL: http://localhost:8000/admin/reservations
- Filter by status: "Pending", "Not Contacted"
- Shows: Name, Email, Trip Type, Date, Guests, Contact Status
- Counts: Total pending, not contacted, this week
```

### Step 2: Mark as Contacted
- Click reservation
- Click "Mark Contacted" button
- Status changes to "contacted"
- `admin_contacted` flag set to true
- `contacted_at` timestamp recorded

### Step 3: Convert to Booking
- Click reservation
- Click "Convert to Booking" button
- Enter booking amount (SAR)
- Click "Convert"
- **System creates:**
  - New `Booking` record with status='pending', payment_status='pending'
  - Details include: trip_title, trip_slug, name, email, phone, amount
  - `converted_from_reservation` field references reservation ID
- **System updates:**
  - Reservation status → 'converted'
  - Reservation `converted_booking_id` → booking ID

### Step 4: Customer Pays
- Customer logs in with their email
- Sees new booking in dashboard
- Clicks "Pay Now"
- Completes payment
- Booking status → 'confirmed', payment_status → 'paid'

---

## Frontend API Client Methods

### bookingsAPI
```javascript
// Create guest reservation (public)
bookingsAPI.createGuest({
  name, email, phone, date, guests, 
  trip_slug, trip_title, trip_type, details
})

// Get authenticated user's bookings
bookingsAPI.getAll()  // GET /api/bookings

// Check booking status
bookingsAPI.checkStatus(id)
```

### reservationsAPI
```javascript
// Submit reservation (public)
reservationsAPI.submit({ ... })

// Check reservation status by email + ID
reservationsAPI.checkStatus(email, reservationId)

// Get logged-in user's reservations
reservationsAPI.getMyReservations()  // GET /api/my-reservations
```

---

## Key Model Methods

### Reservation Model
```php
$reservation->isPending()        // status === 'pending'
$reservation->hasBeenContacted() // admin_contacted || status === 'contacted'
$reservation->isConverted()      // status === 'converted' && converted_booking_id
$reservation->convertedBooking() // Relation to Booking model
```

### Booking Model
```php
$booking->getBookingNumberAttribute() // ID + 1000 (e.g., 1 → 1001)
$booking->payments()                  // Relation to Payment model
$booking->latestPayment()             // hasOne latest payment
```

---

## Status Transitions

### Reservation Status Flow
```
pending
  ↓
contacted (admin marks as contacted)
  ↓
confirmed (optional intermediate status)
  ↓
converted → Creates a Booking record
  ↓
  
If customer doesn't respond → cancelled
```

### Booking Status Flow
```
pending (created from converted reservation)
  ↓
confirmed (after payment)
  ↓
completed (when delivery done)

Or:
pending → cancelled (if customer cancels)
```

### Payment Status Flow
```
pending (booking created, awaiting payment)
  ↓
paid (payment successful)
  ↓
Or:
failed (payment failed)
```

---

## Important Notes

1. **Guest Bookings**: When first submitted, go to `reservations` table (not `bookings`)
2. **Email Matching**: When user logs in, bookings are fetched if:
   - `user_id = authenticated user ID`, OR
   - `details->email = authenticated user email` (guest bookings)
3. **Admin Contact**: Admin must contact customer within 24 hours
4. **Conversion**: Only admins can convert reservations to bookings (Filament UI)
5. **Payment**: Customers can only pay after booking is created (post-conversion)
6. **No Email Sending**: System no longer sends admin emails on guest booking submission
7. **Bilingual Support**: All reservation/booking fields support both EN and AR

---

## Testing the Workflow

### Manual Test Steps:

1. **Submit Reservation (Guest)**
   ```bash
   curl -X POST http://localhost:8000/api/bookings/guest \
     -H "Content-Type: application/json" \
     -d '{
       "name": "Test User",
       "email": "test@example.com",
       "phone": "+966501234567",
       "trip_type": "activity",
       "trip_title": "Desert Safari",
       "date": "2026-02-15",
       "guests": 2
     }'
   ```

2. **Check Status (Guest)**
   ```bash
   curl -X POST http://localhost:8000/api/reservations/check-status \
     -H "Content-Type: application/json" \
     -d '{
       "email": "test@example.com",
       "reservation_id": 1
     }'
   ```

3. **Login as Customer**
   - Login with email: test@example.com
   - Check dashboard (empty until booking is created)
   - Check `/api/my-reservations` (shows pending reservation)

4. **Admin Converts to Booking**
   - Go to http://localhost:8000/admin/reservations
   - Find the reservation
   - Click "Convert to Booking"
   - Enter amount: 500
   - Confirm

5. **Customer Sees Booking**
   - User refreshes dashboard
   - Should see booking with payment status 'pending'
   - Can click "Pay Now" to process payment

---

## Troubleshooting

### Reservation not showing in admin panel
- Check: `reservations` table has records
- Check: Admin user has "consultant" or "super_admin" role
- Check: Filament Resource is registered

### User can't see booking after conversion
- Check: Booking has `details->email` matching user email
- Check: User is logged in with matching email
- Check: Database query returns results

### Payment fails after conversion
- Check: Booking ID exists
- Check: Payment table foreign key references correct booking
- Check: Payment gateway webhook is configured

---

## Related Files

- Backend: [BookingController.php](app/Http/Controllers/Api/BookingController.php#L109)
- Backend: [ReservationController.php](app/Http/Controllers/Api/ReservationController.php)
- Backend: [ReservationResource.php](app/Filament/Resources/ReservationResource.php)
- Frontend: [BookingModal.js](../../tilrimal-frontend/components/IslandDestinations/BookingModal.js)
- Routes: [api.php](routes/api.php#L156)

---

**Last Updated:** January 15, 2026
**Status:** ✅ Implemented and Tested
