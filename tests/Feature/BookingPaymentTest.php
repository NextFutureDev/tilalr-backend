<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Booking;

class BookingPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_booking_and_pay_success()
    {
        // Create a booking via API
        $payload = [
            'service_id' => 1,
            'date' => now()->addDays(5)->toDateString(),
            'guests' => 2,
            'details' => ['notes' => 'No allergies']
        ];

        $create = $this->postJson('/api/bookings', $payload);
        $create->assertStatus(201)->assertJsonStructure(['booking' => ['id','service_id','date','payment_status']]);

        $bookingId = $create->json('booking.id');

        $pay = $this->postJson('/api/payments', ['booking_id' => $bookingId, 'method' => 'dummy', 'simulate' => 'success']);
        $pay->assertStatus(200)->assertJsonPath('result.status', 'paid');

        $this->assertDatabaseHas('bookings', ['id' => $bookingId, 'payment_status' => 'paid']);
        $this->assertDatabaseHas('payments', ['booking_id' => $bookingId, 'status' => 'paid']);
    }
}