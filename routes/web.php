<?php

use Illuminate\Support\Facades\Route;

// Redirect root to admin panel
Route::get('/', function () {
    return redirect('/admin');
});

// Local-only debug route to inspect APP_KEY and environment during HTTP requests
Route::get('/debug_key', function () {
    if (!app()->environment('local')) {
        abort(404);
    }

    $envPath = base_path('.env');
    $envExists = file_exists($envPath);
    $envSample = $envExists ? substr(file_get_contents($envPath), 0, 200) : null;

    return response()->json([
        'env_key' => env('APP_KEY'),
        'config_key' => config('app.key'),
        'env_file_exists' => $envExists,
        'env_sample' => $envSample,
        'base_path' => base_path(),
    ]);
});

// Temporary debug route - only active in local environment
Route::get('/debug/offers', function () {
    if (!app()->environment('local')) {
        abort(404);
    }

    return response()->json(App\Models\Offer::all());
});

// Debug route to inspect the query Filament would be using for the Offers table
Route::get('/debug/offers-query', function () {
    if (!app()->environment('local')) {
        abort(404);
    }

    $model = App\Filament\Resources\OfferResource::getModel();
    $query = $model::query();

    return response()->json([
        'model' => $model,
        'count' => $query->count(),
        'sample' => $query->limit(10)->get(),
        'sql' => $query->toSql(),
    ]);
});

// Public debug page (local only) that renders offers as plain HTML (no auth required)
Route::get('/debug/admin-offers-public', function () {
    if (!app()->environment('local')) {
        abort(404);
    }

    $offers = App\Models\Offer::all();
    return view('debug.offers_public', compact('offers'));
});

// Legacy admin routes disabled in favor of Filament
// use App\Http\Controllers\Admin\AuthController;
// use App\Http\Controllers\Admin\DashboardController;

// Trigger OfferResource table debug log without visiting admin UI
Route::get('/debug/trigger-offerresource', function () {
    if (!app()->environment('local')) {
        abort(404);
    }

    try {
        \Illuminate\Support\Facades\Log::debug('OfferResource::trigger - Offer count: ' . App\Models\Offer::count());
        // attempt to instantiate the table to call the resource table method
        $table = new (\Filament\Tables\Table::class)();
        // call the method to trigger internal logging we added there
        App\Filament\Resources\OfferResource::table($table);
        return response()->json(['success' => true, 'message' => 'OfferResource trigger fired. Check logs.']);
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::debug('OfferResource::trigger error: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
});

// Admin-only debug page to render Offer::all() within admin layout
Route::get('/admin/debug-offers', function () {
    if (!app()->environment('local')) {
        abort(404);
    }

    if (!auth()->check()) {
        return redirect('/admin');
    }

    $offers = App\Models\Offer::all();
    return view('filament.debug_offers', compact('offers'));
});

// Backwards compatibility redirect: map old Products admin paths to Offers
Route::get('/admin/products{any?}', function ($any = null) {
    // remove leading slash from any and append to /admin/offers
    $suffix = $any ? '/' . ltrim($any, '/') : '';
    return redirect('/admin/offers' . $suffix);
})->where('any', '.*');

// Admin-only server-side create endpoint for quick E2E management (local only)
Route::post('/admin/debug-offers/create', function (\Illuminate\Http\Request $request) {
    if (!app()->environment('local')) {
        abort(404);
    }

    if (!auth()->check()) {
        return redirect('/admin');
    }

    $data = $request->validate([
        'title_en' => 'required|string|max:255',
        'title_ar' => 'nullable|string|max:255',
        'slug' => 'nullable|string|max:255',
        'image' => 'nullable|string|max:255',
        'discount' => 'nullable|string|max:50',
        'badge' => 'nullable|string|max:100',
        'duration' => 'nullable|string|max:100',
        'location_en' => 'nullable|string|max:255',
        'group_size' => 'nullable|string|max:100',
        'features' => 'nullable|string',
        'highlights' => 'nullable|string',
        'description_en' => 'nullable|string',
        'is_active' => 'nullable',
    ]);

    // Normalize fields
    $features = array_values(array_filter(array_map('trim', explode(',', $data['features'] ?? ''))));
    $highlights = array_values(array_filter(array_map('trim', explode(',', $data['highlights'] ?? ''))));

    $offer = App\Models\Offer::create([
        'slug' => $data['slug'] ?: \Illuminate\Support\Str::slug($data['title_en']),
        'image' => $data['image'] ?: null,
        'title_en' => $data['title_en'],
        'title_ar' => $data['title_ar'] ?? null,
        'description_en' => $data['description_en'] ?? null,
        'description_ar' => null,
        'duration' => $data['duration'] ?? null,
        'location_en' => $data['location_en'] ?? null,
        'location_ar' => null,
        'group_size' => $data['group_size'] ?? null,
        'discount' => $data['discount'] ?? null,
        'badge' => $data['badge'] ?? null,
        'features' => $features,
        'highlights' => $highlights,
        'is_active' => $request->has('is_active') ? 1 : 0,
    ]);

    return redirect('/admin/debug-offers')->with('success', 'Offer created: ' . $offer->title_en);
});

// Test upload routes (local only)
Route::middleware('local-only')->group(function () {
    Route::post('/test/upload', 'App\Http\Controllers\TestUploadController@upload');
    Route::post('/test/upload-island/{id}', 'App\Http\Controllers\TestUploadController@setImage');
});
