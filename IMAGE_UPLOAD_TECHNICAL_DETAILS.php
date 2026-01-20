/**
 * IMAGE UPLOAD ISSUE - TECHNICAL DEEP DIVE
 * ==========================================
 * 
 * This file explains the exact technical problem and solution
 */

// ================================================================
// THE PROBLEM: HARDCODED IMAGE PATHS
// ================================================================

// BEFORE (WRONG - In old seeder):
IslandDestination::create([
    'slug' => 'trip-to-alula',
    'title_en' => 'Trip to AlUla',
    'image' => '/354.jpeg',  // ❌ HARDCODED PATH - FILE DOESN'T EXIST!
    'price' => 354.00,
]);

// What happens:
// 1. Database stores: image = "/354.jpeg"
// 2. API returns: { "image": "/354.jpeg" }
// 3. Frontend builds URL: http://localhost:8000/storage/354.jpeg
// 4. Browser looks for: storage/app/public/354.jpeg
// 5. Result: FILE NOT FOUND ❌ 404 ERROR

// Real files in storage:
// - storage/app/public/islands/01KEKSHB4X...jpeg  ← These exist!
// - storage/app/public/354.jpeg                  ← This does NOT!


// ================================================================
// THE SOLUTION: NULL IMAGES + FILAMENT UPLOAD
// ================================================================

// AFTER (CORRECT - Updated seeder):
IslandDestination::create([
    'slug' => 'trip-to-alula',
    'title_en' => 'Trip to AlUla',
    'image' => null,  // ✅ NULL - Admin must upload via Filament
    'price' => 354.00,
]);

// How Filament upload works:
// 1. Admin uploads via: /admin (Island Destinations page)
// 2. Filament receives file
// 3. Filament stores to: storage/app/public/islands/ (as defined)
// 4. Filament generates unique ID: 01KEKSHB4XM8ZC5AE3Z5BYA9RH
// 5. Filament saves path to database: /islands/01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg
// 6. API returns: { "image": "/islands/01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg" }
// 7. Frontend builds URL: http://localhost:8000/storage/islands/...jpeg
// 8. File exists: storage/app/public/islands/01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg
// 9. Result: IMAGE DISPLAYS ✅


// ================================================================
// PATH CONSTRUCTION & VALIDATION
// ================================================================

// Stored in DB:
$storedPath = "/islands/01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg";

// Filament configuration (app/Filament/Resources/IslandDestinationResource.php):
Forms\Components\FileUpload::make('image')
    ->image()                           // Only accept images
    ->directory('islands')              // Save to: storage/app/public/islands/
    ->label('Island Image'),

// API response construction (app/Http/Controllers/Api/IslandDestinationController.php):
$island = IslandDestination::find($id);
return [
    'image' => $island->image,  // Returns: "/islands/01KEKSHB4X...jpeg" or null
];

// Frontend construction (React):
const API_BASE = 'http://localhost:8000';
const imageUrl = destination.image 
    ? `${API_BASE}/storage${destination.image}`  // http://localhost:8000/storage/islands/...
    : '/placeholder.jpg';

// Browser request:
// GET http://localhost:8000/storage/islands/01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg

// Apache/Web Server routing:
// public/storage/ ← Symlink
//   └─> storage/app/public/
//       └─> islands/
//           └─> 01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg ✅ FILE FOUND


// ================================================================
// CONFIGURATION CHAIN
// ================================================================

/*
 * .env
 * └─ FILESYSTEM_DISK=local
 *    └─ Uses 'local' disk from config/filesystems.php
 *       └─ public disk configuration:
 *          ├─ root: storage/app/public
 *          ├─ url: http://localhost:8000/storage
 *          └─ visibility: public
 *             └─ Filament uses directory('islands')
 *                └─ Stores in: storage/app/public/islands/
 *                   └─ Accessible via: public/storage/ (symlink)
 *                      └─ Web URL: http://localhost:8000/storage/islands/
 */


// ================================================================
// DATABASE BEFORE & AFTER
// ================================================================

// BEFORE (WRONG):
/*
 * SELECT id, slug, image FROM island_destinations;
 *
 * id | slug              | image
 * ---|-------------------|------------------
 * 10 | trip-to-alula     | /354.jpeg          ❌ 404 - FILE NOT FOUND
 * 11 | alula-two-days    | /1800.jpeg         ❌ 404 - FILE NOT FOUND
 * 12 | alula-three-days  | /3200.jpeg         ❌ 404 - FILE NOT FOUND
 *
 * Problem: Hardcoded paths that don't correspond to actual files
 */

// AFTER (CORRECT):
/*
 * SELECT id, slug, image FROM island_destinations;
 *
 * id | slug              | image
 * ---|-------------------|------------------
 * 13 | trip-to-alula     | NULL               ✅ Ready for upload
 * 14 | alula-two-days    | NULL               ✅ Ready for upload
 * 15 | alula-three-days  | NULL               ✅ Ready for upload
 *
 * Solution: NULL values until admin uploads via Filament
 */

// FUTURE (AFTER UPLOADING):
/*
 * SELECT id, slug, image FROM island_destinations;
 *
 * id | slug              | image
 * ---|-------------------|----------------------------------------------
 * 13 | trip-to-alula     | /islands/01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg   ✅
 * 14 | alula-two-days    | /islands/01KE74R0N941B7SE4GMC9QSPA3.png    ✅
 * 15 | alula-three-days  | /islands/01KECAX4TC3N9RB5A54CB1A4EK.jpeg   ✅
 *
 * Result: Real files exist, images display correctly
 */


// ================================================================
// FILE SYSTEM STRUCTURE
// ================================================================

/*
 * Storage directory structure:
 *
 * tilrimal-backend/
 * ├── storage/
 * │   └── app/
 * │       └── public/
 * │           └── islands/                    ← ACTUAL FILES
 * │               ├── 01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg
 * │               ├── 01KE74R0N941B7SE4GMC9QSPA3.png
 * │               ├── 01KECAX4TC3N9RB5A54CB1A4EK.jpeg
 * │               └── (more uploaded images...)
 * │
 * └── public/
 *     └── storage/                            ← SYMLINK
 *         └── (points to storage/app/public/)
 *             └── islands/                    ← WEB ACCESSIBLE
 *                 └── (same files as above)
 *
 * Web access path:
 * http://localhost:8000/storage/islands/01KEKSHB4X...jpeg
 *                      └──────┬───────┘
 *                         symlink: public/storage
 *                         ├─ root: storage/app/public
 *                         └─ url: http://localhost:8000/storage
 */


// ================================================================
// FILAMENT CONFIGURATION
// ================================================================

// File: app/Filament/Resources/IslandDestinationResource.php

Forms\Components\Section::make('Media & Status')
    ->schema([
        Forms\Components\FileUpload::make('image')
            ->image()                          // ← Only JPG, PNG, WebP
            ->directory('islands')             // ← Save to: storage/app/public/islands
            ->label('Island Image'),           // ← Label in form
        Forms\Components\Toggle::make('active')
            ->label('Active')
            ->default(true),
    ])->columns(2),

// When user uploads:
// 1. File selected in browser
// 2. Sent to /upload endpoint (handled by Filament)
// 3. Validated as image
// 4. Stored to: storage/app/public/islands/[ULID].extension
// 5. ULID (Unique Lexicographically Sortable Identifier) generated
// 6. Path saved to database: /islands/[ULID].extension
// 7. Database updated immediately
// 8. Form saved
// 9. Redirect to list view


// ================================================================
// API FLOW
// ================================================================

// Request:
// GET http://localhost:8000/api/island-destinations/local

// Route (routes/api.php):
Route::get('/island-destinations/local', [IslandDestinationController::class, 'getLocal']);

// Controller method (app/Http/Controllers/Api/IslandDestinationController.php):
public function getLocal()
{
    $destinations = IslandDestination::where('type', 'local')
        ->where('active', true)
        ->get();
    
    return response()->json([
        'success' => true,
        'data' => $destinations,  // ← Returns all columns including image
    ]);
}

// Response before upload:
{
    "success": true,
    "data": [
        {
            "id": 13,
            "slug": "trip-to-alula",
            "title_en": "Trip to AlUla",
            "image": null,  // ← NULL until uploaded
            "price": "354.00",
            ...
        }
    ]
}

// Response after upload:
{
    "success": true,
    "data": [
        {
            "id": 13,
            "slug": "trip-to-alula",
            "title_en": "Trip to AlUla",
            "image": "/islands/01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg",  // ← Path stored
            "price": "354.00",
            ...
        }
    ]
}


// ================================================================
// FRONTEND DISPLAY
// ================================================================

// React component:
function IslandCard({ destination }) {
    const buildImageUrl = (imagePath) => {
        if (!imagePath) return '/placeholder.jpg';
        
        // imagePath = "/islands/01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg"
        const API_BASE = 'http://localhost:8000';
        return `${API_BASE}/storage${imagePath}`;
        // Result: http://localhost:8000/storage/islands/01KEKSHB4X...jpeg
    };
    
    return (
        <img 
            src={buildImageUrl(destination.image)}
            alt={destination.title_en}
            onError={(e) => e.target.src = '/placeholder.jpg'}
        />
    );
}


// ================================================================
// DIAGNOSTIC COMMANDS
// ================================================================

// Check configuration:
php test_image_upload.php

// Expected output:
// ✅ Storage/app/public exists: YES
// ✅ Storage/app/public/islands exists: YES
// ✅ Public/storage symlink exists: YES
// ✅ Directories writable: YES

// Check database:
php artisan tinker
>>> $island = \App\Models\IslandDestination::find(13);
>>> dd($island->image);  // Should show: null or "/islands/..."

// Check file exists:
>>> file_exists(storage_path('app/public/islands/01KEKSHB4XM8ZC5AE3Z5BYA9RH.jpeg'));


// ================================================================
// SUMMARY
// ================================================================

/*
 * WHAT WAS WRONG:
 * • Seeder had hardcoded image paths
 * • Paths didn't match actual files
 * • Database stored non-existent paths
 * • API returned broken paths
 * • Frontend displayed 404 images
 *
 * WHAT WAS FIXED:
 * • Removed hardcoded paths
 * • Set images to NULL in database
 * • Verified Filament upload configuration
 * • Verified storage symlink works
 * • Verified directories are writable
 *
 * NEXT STEPS:
 * • Admin uploads image via Filament panel
 * • Filament stores file with unique ID
 * • Database path is auto-populated
 * • API returns correct path
 * • Frontend displays image ✅
 *
 * UPLOAD INSTRUCTIONS:
 * 1. Go to http://localhost:8000/admin
 * 2. Login: superadmin@tilalr.com / password123
 * 3. Destinations → Island Destinations
 * 4. Click Edit on any trip
 * 5. Scroll to Media & Status
 * 6. Click image upload area
 * 7. Select image file
 * 8. Click Save
 * 9. Image now displays ✅
 */
