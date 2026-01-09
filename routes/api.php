<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\TeamMemberController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\InternationalFlightController;
use App\Http\Controllers\Api\InternationalHotelController;
use App\Http\Controllers\Api\InternationalPackageController;
use App\Http\Controllers\Api\InternationalDestinationController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\TestDataController;
use App\Http\Controllers\Api\IslandDestinationController;

// Health check routes
Route::get('/health', [HealthController::class, 'check']);
Route::get('/health/db', [HealthController::class, 'dbTest']);

// Test data routes (Development only - remove in production)
Route::post('/test-data/create-users', [TestDataController::class, 'createTestUsers']);

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public API routes for frontend
Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{slug}', [PageController::class, 'show']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{slug}', [ServiceController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

Route::get('/trips', [TripController::class, 'index']);
Route::get('/trips/{slug}', [TripController::class, 'show']);

Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/{slug}', [CityController::class, 'show']);

Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/testimonials/{id}', [TestimonialController::class, 'show']);

Route::get('/team-members', [TeamMemberController::class, 'index']);
Route::get('/team-members/{id}', [TeamMemberController::class, 'show']);

Route::get('/settings', [SettingController::class, 'index']);
Route::get('/settings/{key}', [SettingController::class, 'show']);

// International Travel API routes (public)
Route::get('/international/flights', [InternationalFlightController::class, 'index']);
Route::get('/international/flights/{id}', [InternationalFlightController::class, 'show']);

Route::get('/international/hotels', [InternationalHotelController::class, 'index']);
Route::get('/international/hotels/{id}', [InternationalHotelController::class, 'show']);

Route::get('/international/packages', [InternationalPackageController::class, 'index']);
Route::get('/international/packages/{id}', [InternationalPackageController::class, 'show']);

Route::get('/international/destinations', [InternationalDestinationController::class, 'index']);

// Public Offers API
Route::get('/offers', [\App\Http\Controllers\Api\OfferController::class, 'index']);
Route::get('/offers/{id}', [\App\Http\Controllers\Api\OfferController::class, 'show']);

// Admin CRUD endpoints (optional)
Route::post('/admin/offers', [\App\Http\Controllers\Api\OfferController::class, 'store']);
Route::put('/admin/offers/{id}', [\App\Http\Controllers\Api\OfferController::class, 'update']);
Route::delete('/admin/offers/{id}', [\App\Http\Controllers\Api\OfferController::class, 'destroy']);
Route::get('/international/destinations/{id}', [InternationalDestinationController::class, 'show']);

// Island Destinations
Route::get('/island-destinations', [IslandDestinationController::class, 'index']);
// Local endpoints must be declared before the dynamic {id} route to avoid being captured as an id
Route::get('/island-destinations/local', [IslandDestinationController::class, 'indexLocal']);
Route::get('/island-destinations/local/{id}', [IslandDestinationController::class, 'show']);
// Dynamic show (by id or slug)
Route::get('/island-destinations/{id}', [IslandDestinationController::class, 'show']);
// Allow creating a new island destination (accepts city_id or city_name to link city)
Route::post('/island-destinations', [IslandDestinationController::class, 'store']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // User authentication routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    
    // User bookings
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::put('/bookings/{id}', [BookingController::class, 'update']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
    
    // User payments
    Route::post('/payments/initiate', [PaymentController::class, 'initiate']);
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::get('/payments/{id}', [PaymentController::class, 'show']);
    
    // Admin routes for International Travel (CRUD operations)
    Route::post('/international/flights', [InternationalFlightController::class, 'store']);
    Route::put('/international/flights/{id}', [InternationalFlightController::class, 'update']);
    Route::delete('/international/flights/{id}', [InternationalFlightController::class, 'destroy']);
    
    Route::post('/international/hotels', [InternationalHotelController::class, 'store']);
    Route::put('/international/hotels/{id}', [InternationalHotelController::class, 'update']);
    Route::delete('/international/hotels/{id}', [InternationalHotelController::class, 'destroy']);
    
    Route::post('/international/packages', [InternationalPackageController::class, 'store']);
    Route::put('/international/packages/{id}', [InternationalPackageController::class, 'update']);
    Route::delete('/international/packages/{id}', [InternationalPackageController::class, 'destroy']);
    
    Route::post('/international/destinations', [InternationalDestinationController::class, 'store']);
    Route::put('/international/destinations/{id}', [InternationalDestinationController::class, 'update']);
    Route::delete('/international/destinations/{id}', [InternationalDestinationController::class, 'destroy']);

    // Admin CRUD for Island Destinations (international and local)
    Route::post('/admin/island-destinations', [IslandDestinationController::class, 'store']);
    Route::put('/admin/island-destinations/{id}', [IslandDestinationController::class, 'update']);
    Route::delete('/admin/island-destinations/{id}', [IslandDestinationController::class, 'destroy']);
    // Local-specific create (admin)
    Route::post('/admin/island-destinations/local', [IslandDestinationController::class, 'storeLocal']);
});

// Payment webhooks (public for payment gateway callbacks)
Route::post('/payments/webhook/telr', [PaymentController::class, 'telrWebhook']);
Route::post('/payments/webhook/moyasar', [PaymentController::class, 'moyasarWebhook']);
Route::get('/payments/callback', [PaymentController::class, 'callback']);

// Booking & Payment public endpoints (for guest bookings if needed)
Route::post('/bookings/guest', [BookingController::class, 'guestStore']);
Route::get('/bookings/{id}/status', [BookingController::class, 'checkStatus']);

// ============================================
// RESERVATION SYSTEM (Phase 1 - No Auth Required)
// ============================================
// Public reservation endpoints - anyone can submit without login
Route::post('/reservations', [ReservationController::class, 'store']); // Submit reservation
Route::post('/reservations/check-status', [ReservationController::class, 'checkStatus']); // Check status by email + ID

// Contact form submission (public)
Route::post('/contact', [App\Http\Controllers\Api\ContactController::class, 'store']);

// Admin routes (protected - add authentication later)
Route::prefix('admin')->group(function () {
    Route::post('/pages', [PageController::class, 'store']);
    Route::put('/pages/{id}', [PageController::class, 'update']);
    Route::delete('/pages/{id}', [PageController::class, 'destroy']);
    
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);
    
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    
    Route::post('/trips', [TripController::class, 'store']);
    Route::put('/trips/{id}', [TripController::class, 'update']);
    Route::delete('/trips/{id}', [TripController::class, 'destroy']);
    
    Route::post('/cities', [CityController::class, 'store']);
    Route::put('/cities/{id}', [CityController::class, 'update']);
    Route::delete('/cities/{id}', [CityController::class, 'destroy']);
    
    Route::post('/testimonials', [TestimonialController::class, 'store']);
    Route::put('/testimonials/{id}', [TestimonialController::class, 'update']);
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy']);
    
    Route::post('/team-members', [TeamMemberController::class, 'store']);
    Route::put('/team-members/{id}', [TeamMemberController::class, 'update']);
    Route::delete('/team-members/{id}', [TeamMemberController::class, 'destroy']);
    
    Route::post('/settings', [SettingController::class, 'store']);
    Route::put('/settings/{key}', [SettingController::class, 'update']);
    Route::delete('/settings/{key}', [SettingController::class, 'destroy']);
    
    // Admin Reservation Management
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/statistics', [ReservationController::class, 'statistics']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);
    Route::post('/reservations/{id}/mark-contacted', [ReservationController::class, 'markContacted']);
    Route::post('/reservations/{id}/convert-to-booking', [ReservationController::class, 'convertToBooking']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
});
