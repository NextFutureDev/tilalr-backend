# Booking & Payment API

This document describes the booking and payment API endpoints added to the backend.

Base URL: /api

## Endpoints

POST /api/bookings
- Create a booking
Request body:
```json
{
  "user_id": 1,               // optional
  "service_id": 123,         // optional (integer) or service_slug instead
  "service_slug": "island-tour", // optional
  "date": "2025-12-25",
  "guests": 2,
  "details": { "notes": "No allergies" }
}
```
Response (201):
```json
{ "booking": { "id": 1, "service_id": 123, "date": "2025-12-25", "payment_status":"pending" } }
```

GET /api/bookings/{id}
- Get booking with payments
Response (200):
```json
{ "booking": { "id": 1, "payments": [ ... ] } }
```

POST /api/payments
- Initiate a payment (dummy)
Request body:
```json
{ "booking_id": 1, "method": "dummy", "simulate": "success|fail" }
```
Response (200):
```json
{ "payment": { "id": 1, "status": "paid" }, "result": { "status": "paid", "transaction_id": "DUMMY_..." } }
```

GET /api/payments/{id}
- Get payment

## Notes
- The `simulate` parameter allows deterministic test results (use `success` or `fail`).
- Payment service returns a simulated transaction id and updates booking `payment_status` and `status`.

## To run migrations
1. Ensure `.env` DB variables are configured for MySQL.
2. Run `php artisan migrate`.

