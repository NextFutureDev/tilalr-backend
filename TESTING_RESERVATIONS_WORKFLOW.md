# Testing the Reservations & Bookings Workflow

## Prerequisites
- Backend running: `php artisan serve` (localhost:8000)
- Frontend running: `npm run dev` (localhost:3000)
- Admin panel: http://localhost:8000/admin

---

## Test 1: Submit a Reservation via Frontend

### Step 1: Go to Website
- URL: http://localhost:3000/en/international (or /ar/international)
- OR: http://localhost:3000/en/local-islands (for local activities)

### Step 2: Click Booking Button
- Select a destination or activity
- Click the booking button (e.g., "Book Now")

### Step 3: Fill Booking Form
- **Step 1 (Booking Type)**
  - For International: Select a category (Activities, Hotel, Flight, Package)
  - For Local: Local Activities are already selected
  
- **Step 2 (Details)**
  - Enter dates, rooms, etc.
  
- **Step 3 (Contact Info)**
  - Name: "Ahmed Al-Rashid"
  - Email: "ahmed@example.com"
  - Phone: "+966501234567"

### Step 4: Submit
- Click "Complete Payment" button
- You should see confirmation page:
  - EN: "Local Activities Reservation Received" or "International Booking Reservation Received"
  - AR: "تم استلام طلب الحجز (أنشطة محلية)" or "تم استلام طلب الحجز الدولي"

---

## Test 2: Admin Reviews Reservation

### Step 1: Go to Admin Panel
- URL: http://localhost:8000/admin
- Login with admin credentials

### Step 2: Navigate to Reservations
- Left sidebar → "Reservations & Bookings" → "Reservations"
- You should see your submitted reservation at the top
- Status: **"Pending"** (yellow badge)

### Step 3: View Reservation Details
- Click on the reservation row
- You'll see:
  - Name: "Ahmed Al-Rashid"
  - Email: "ahmed@example.com"
  - Trip Type: "activity" (or whichever was selected)
  - Status: "pending"
  - Admin Contacted: FALSE

---

## Test 3: Admin Marks as Contacted

### Step 1: Click "Mark Contacted" Button
- Still on reservation details page
- Click the **"Mark Contacted"** button

### Step 2: Confirm Action
- A confirmation dialog appears
- Click "Confirm"

### Step 3: Verify
- Notification appears: "Reservation marked as contacted"
- Status changes to: "contacted"
- Admin Contacted: TRUE
- Contacted At: [current timestamp]

---

## Test 4: Admin Converts to Booking

### Step 1: Click "Convert to Booking" Button
- Still on reservation details page
- Click the **"Convert to Booking"** button
- A modal appears: "Convert Reservation to Booking"

### Step 2: Enter Booking Amount
- Label: "Booking Amount (SAR)"
- Enter amount: "500"
- Click "Convert"

### Step 3: Verify Conversion
- Notification: "Reservation converted to booking #[id]"
- Reservation status: "converted"
- New Booking ID appears in reservation
- **Booking is now in the `bookings` table**

---

## Test 5: User Logs In and Sees Booking

### Step 1: Go to Website
- URL: http://localhost:3000/en/login (or /ar/login)

### Step 2: Login with Customer Email
- Email: "ahmed@example.com"
- Phone: "+966501234567" (or use OTP if configured)
- Click "Login"

### Step 3: Go to Dashboard
- After login, click "Dashboard" in navbar
- URL: http://localhost:3000/en/dashboard (or /ar/dashboard)

### Step 4: View Booking
- Under "My Bookings" tab
- Should see the converted booking:
  - Trip Title: [the destination name]
  - Date: [the selected date]
  - Guests: [number of guests]
  - Status: "Pending"
  - Payment Status: "Unpaid"

---

## Test 6: Check Reservation Status (Public)

### Via API (curl)
```bash
curl -X POST http://localhost:8000/api/reservations/check-status \
  -H "Content-Type: application/json" \
  -d '{
    "email": "ahmed@example.com",
    "reservation_id": 1
  }'
```

### Expected Response
```json
{
  "success": true,
  "reservation": {
    "id": 1,
    "status": "converted",
    "trip_title": "Desert Safari Experience",
    "preferred_date": "2026-02-15",
    "guests": 4,
    "created_at": "2025-01-15T10:30:00Z",
    "admin_contacted": true
  }
}
```

---

## Test 7: Check User's Reservations (Authenticated)

### Via API (curl with token)
```bash
# First, get auth token by logging in
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "ahmed@example.com", "password": "password"}'

# Then use token to check reservations
curl -X GET http://localhost:8000/api/my-reservations \
  -H "Authorization: Bearer {your_auth_token}"
```

### Expected Response
```json
{
  "success": true,
  "reservations": [
    {
      "id": 1,
      "name": "Ahmed Al-Rashid",
      "email": "ahmed@example.com",
      "trip_title": "Desert Safari Experience",
      "trip_type": "activity",
      "status": "converted",
      "preferred_date": "2026-02-15",
      "guests": 4,
      "admin_contacted": true,
      "converted_booking_id": 5,
      "created_at": "2025-01-15T10:30:00Z"
    }
  ]
}
```

---

## Test 8: Check Booking Details (Authenticated)

### Via API
```bash
curl -X GET http://localhost:8000/api/bookings \
  -H "Authorization: Bearer {your_auth_token}"
```

### Expected Response
```json
{
  "bookings": [
    {
      "id": 5,
      "user_id": null,
      "date": "2026-02-15",
      "guests": 4,
      "status": "pending",
      "payment_status": "pending",
      "details": {
        "name": "Ahmed Al-Rashid",
        "email": "ahmed@example.com",
        "phone": "+966501234567",
        "trip_title": "Desert Safari Experience",
        "trip_type": "activity",
        "amount": 500,
        "converted_from_reservation": 1
      },
      "created_at": "2025-01-15T11:00:00Z",
      "payments": []
    }
  ]
}
```

---

## Test 9: Check Database Directly

### Check Reservations Table
```sql
SELECT id, name, email, trip_type, status, admin_contacted, converted_booking_id
FROM reservations
WHERE email = 'ahmed@example.com'
ORDER BY created_at DESC
LIMIT 1;
```

**Expected:**
```
id | name              | email                | trip_type | status    | admin_contacted | converted_booking_id
1  | Ahmed Al-Rashid   | ahmed@example.com    | activity  | converted | 1               | 5
```

### Check Bookings Table
```sql
SELECT id, user_id, date, status, payment_status, details
FROM bookings
WHERE details->>'$.email' = 'ahmed@example.com'
ORDER BY created_at DESC
LIMIT 1;
```

**Expected:**
```
id | user_id | date       | status  | payment_status | details
5  | NULL    | 2026-02-15 | pending | pending        | {"name": "Ahmed Al-Rashid", ...}
```

---

## Troubleshooting

### Issue: Reservation not showing in admin panel
**Solution:**
1. Check database: `SELECT * FROM reservations;`
2. Verify admin user has "consultant" or "super_admin" role
3. Clear Filament cache: `php artisan cache:clear`
4. Refresh browser

### Issue: "Convert to Booking" button not visible
**Solution:**
1. Make sure reservation status is NOT "converted" already
2. Admin must have proper permissions
3. Try: `php artisan cache:clear`

### Issue: User doesn't see booking after conversion
**Solution:**
1. Check: Is user logged in with matching email?
2. Check database: Booking's `details->email` matches user's email
3. Try: Logout and login again
4. Check API: `curl http://localhost:8000/api/bookings` (with auth token)

### Issue: "File not found" 404 errors
**Solution:**
1. Frontend build successful? `npm run build --silent`
2. Routes registered? Check: `routes/api.php` line 156+
3. Controllers imported? Check: `routes/api.php` top

### Issue: API returns 401 Unauthorized
**Solution:**
1. Auth token expired? Login again
2. Token not in request? Add header: `Authorization: Bearer {token}`
3. Token format wrong? Should be: `Bearer {actual_token_value}`

---

## Success Indicators

### ✅ All tests passed if:
1. Reservation shows in admin panel after submission
2. "Mark Contacted" button works
3. "Convert to Booking" creates a booking record
4. User sees booking in dashboard after login
5. Booking email matches user's login email
6. Database shows: reservation.status = 'converted', reservation.converted_booking_id = booking.id
7. API endpoints return correct data

---

## Next Steps After Testing

1. **Payment Integration**
   - When user clicks "Pay Now", integrate with Moyasar/payment gateway
   - Update booking.payment_status = 'paid'

2. **Admin Notifications**
   - Optional: Send email to admin when new reservation submitted
   - Optional: Send SMS to customer when booking converted

3. **User Notifications**
   - Optional: Email to user when reservation status changes
   - Optional: Display notification in dashboard

4. **Reporting**
   - Admin reports on conversion rates
   - Track average time from reservation to payment

---

**Last Updated:** January 15, 2026  
**Status:** Ready for Testing ✅
