# Guest Count & Rooms Near Each Other - Data Flow Fix

## 🔴 PROBLEM
The form fields (`numberOfGuests`, `roomCount`, `roomsNearEachOther`, `roomsNearEachOtherCount`) were being collected in BookingModal but NOT:
- Being saved to the database
- Showing in the admin panel

## ✅ SOLUTION - COMPLETE DATA FLOW

### 1️⃣ FRONTEND (BookingModal.js) - Already Fixed
✓ Collecting guest count and room preferences
✓ Sending in `details` JSON payload to backend
✓ Payload structure:
```json
{
  "numberOfGuests": "4",
  "roomCount": 2,
  "roomsNearEachOther": true,
  "roomsNearEachOtherCount": 2,
  "checkInDate": "2026-02-01",
  "checkOutDate": "2026-02-05",
  ...
}
```

### 2️⃣ BACKEND - API ENDPOINT

**Route:** `POST /api/bookings/guest`
**Handler:** `BookingController::guestStore()` 
**What it does:**
- Receives the complete `details` object from frontend
- Creates a RESERVATION (not a Booking) in the database
- Saves all details in JSON column

✅ **FIXED:** Updated to properly preserve ALL details from frontend
```php
// Now properly merges and preserves all details including:
// numberOfGuests, roomCount, roomsNearEachOther, roomsNearEachOtherCount
$detailsPayload = $request->input('details', []);
$detailsPayload['amount'] = $request->amount;
$detailsPayload['booking_type'] = $request->trip_type;

$reservation = Reservation::create([
    ...
    'details' => $detailsPayload, // All frontend details preserved
    ...
]);
```

### 3️⃣ DATABASE - SCHEMA

**Table:** `reservations`
**Relevant columns:**
- `guests` (int) - Main guest count field
- `details` (JSON) - Stores all booking details including:
  - `numberOfGuests` - From booking form
  - `roomCount` - Number of hotel rooms
  - `roomsNearEachOther` - Boolean flag
  - `roomsNearEachOtherCount` - How many should be adjacent
  - `checkInDate`, `checkOutDate`, `roomType` - Hotel info
  - All other booking details

### 4️⃣ MODEL - DATA ACCESSORS

**File:** `app/Models/Reservation.php`

Added three accessor methods:

#### `getBookingGuestCountAttribute()`
Retrieves guest count from details or fallback to main guests column
```php
$reservation->booking_guest_count // Returns integer
```

#### `getRoomInfoAttribute()`
Returns array with all room information
```php
$reservation->room_info
// Returns:
// [
//   'roomCount' => 2,
//   'roomsNearEachOther' => true,
//   'roomsNearEachOtherCount' => 2,
//   'roomType' => 'standard'
// ]
```

#### `getRoomSummaryAttribute()`
Human-readable room summary string
```php
$reservation->room_summary
// Returns: "2 rooms (adjacent: 2) - standard"
```

### 5️⃣ ADMIN PANEL - FILAMENT RESOURCE

**File:** `app/Filament/Resources/ReservationResource.php`

✅ **UPDATED TO DISPLAY:**

#### In Table View:
- `Booking Guests` - From details.numberOfGuests
- `Rooms` - From details.roomCount (shows as "2 rooms")
- `Near Each Other` - From details.roomsNearEachOther (shows "✓ Yes" or "No")

#### In Detail View:
New section: "Hotel Booking Details" showing:
- Number of Rooms
- Rooms Near Each Other (toggle)
- Adjacent Rooms Count
- Room Type
- Check-in Date
- Check-out Date

Plus the complete details JSON view at the bottom.

## 📋 DATA FLOW SUMMARY

```
BookingModal.js
     ↓ (sends details + numberOfGuests + roomCount + roomsNearEachOther)
BookingController::guestStore()
     ↓ (preserves all details)
Reservation Model
     ↓ (saves to database with JSON details)
ReservationResource (Filament)
     ↓ (displays via table columns and form fields)
Admin Panel
```

## ✔️ VERIFICATION CHECKLIST

Before submitting a booking:
1. ✓ BookingModal collects data
2. ✓ Click "Complete Payment" submits to `/api/bookings/guest`
3. ✓ Backend logs show `numberOfGuests`, `roomCount`, etc. in details
4. ✓ Database stores in `reservations.details` JSON column

After booking created:
1. ✓ Admin panel shows guest count in "Booking Guests" column
2. ✓ Admin panel shows room count in "Rooms" column  
3. ✓ Admin panel shows "Yes/No" for adjacent rooms in "Near Each Other" column
4. ✓ Click reservation to view detail page
5. ✓ "Hotel Booking Details" section shows all room information
6. ✓ "All Additional Details (JSON)" shows complete raw data

## 🔍 DEBUG COMMANDS

Check latest reservation data:
```bash
php artisan tinker
>>> $res = App\Models\Reservation::latest()->first();
>>> dd($res->details);
>>> dd($res->room_summary);
>>> dd($res->booking_guest_count);
```

Run test script:
```bash
php test_reservation_details.php
```

View logs:
```bash
tail -f storage/logs/laravel.log
```

## 📝 NOTES

- Guest count is stored in TWO places: 
  - `guests` column (direct database field)
  - `details.numberOfGuests` (JSON, from booking form)
  - Admin sees: main `guests` in list, booking form `numberOfGuests` in "Booking Guests" column

- Room information is ONLY in `details` JSON (hotel-specific)

- All data is properly JSON-encoded for database storage and decoded when accessed

- Changes are backward compatible - old reservations without these fields will show "N/A"
