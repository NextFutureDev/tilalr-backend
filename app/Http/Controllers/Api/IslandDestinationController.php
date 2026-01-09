<?php

namespace App\Http\Controllers\Api;

use App\Models\IslandDestination;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IslandDestinationController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type'); // Get 'type' from query parameter (international, local, etc)
        return $this->indexByType($type);
    }

    public function indexLocal()
    {
        return $this->indexByType('local');
    }

    protected function indexByType($type)
    {
        try {
            $query = IslandDestination::where('active', true)->with('city');
            if ($type) $query->where('type', $type);

            $destinations = $query->get()->map(function ($d) {
                // Normalize stored image path to a full URL for the frontend
                $imagePath = $d->image ? ltrim($d->image, '/') : null;
                if ($imagePath) {
                    if (preg_match('/^https?:\/\//', $imagePath) || str_starts_with($imagePath, 'storage/') || str_starts_with($imagePath, '/storage/')) {
                        // already a storage path or absolute URL
                        $d->image = preg_match('/^https?:\/\//', $imagePath) ? $imagePath : asset($imagePath);
                    } else {
                        $d->image = asset('storage/' . $imagePath);
                    }
                } else {
                    $d->image = null;
                }

                // Attach minimal city info if available
                if ($d->city) {
                    $d->city = [
                        'id' => $d->city->id,
                        'name' => $d->city->name ?? null,
                        'slug' => $d->city->slug ?? null,
                    ];
                }

                return $d;
            });

            return response()->json([
                'success' => true,
                'data' => $destinations,
                'message' => 'Island destinations retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving destinations: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $destination = IslandDestination::findOrFail($id);

            // Normalize image path to full URL
            $imagePath = $destination->image ? ltrim($destination->image, '/') : null;
            if ($imagePath) {
                if (preg_match('/^https?:\/\//', $imagePath) || str_starts_with($imagePath, 'storage/') || str_starts_with($imagePath, '/storage/')) {
                    $destination->image = preg_match('/^https?:\/\//', $imagePath) ? $imagePath : asset($imagePath);
                } else {
                    $destination->image = asset('storage/' . $imagePath);
                }
            } else {
                $destination->image = null;
            }

            return response()->json([
                'success' => true,
                'data' => $destination,
                'message' => 'Island destination retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Island destination not found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title_en' => 'required|string',
                'title_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'features' => 'nullable|array',
                'features_en' => 'nullable|array',
                'features_ar' => 'nullable|array',
                'image' => 'nullable|string',
                'price' => 'nullable|numeric',
                'rating' => 'nullable|numeric|between:0,5',
                'active' => 'nullable|boolean',
                'city_id' => 'nullable|integer|exists:cities,id',
                'city_name' => 'nullable|string',
                'slug' => 'nullable|string|unique:island_destinations,slug',
                'type' => 'nullable|string',
            ]);

            // Normalize features fields in case they're sent as JSON strings (e.g., uploads)
            if (isset($validated['features_en']) && is_string($validated['features_en'])) {
                $decoded = json_decode($validated['features_en'], true);
                if (is_array($decoded)) $validated['features_en'] = $decoded;
            }
            if (isset($validated['features_ar']) && is_string($validated['features_ar'])) {
                $decoded = json_decode($validated['features_ar'], true);
                if (is_array($decoded)) $validated['features_ar'] = $decoded;
            }

            // Handle city linkage: prefer city_id, otherwise create/find by city_name
            $cityId = $validated['city_id'] ?? null;
            if (!$cityId && !empty($validated['city_name'])) {
                $slug = \Illuminate\Support\Str::slug($validated['city_name']);
                $city = City::firstOrCreate([
                    'slug' => $slug
                ], [
                    'name' => $validated['city_name'],
                    'lang' => 'en',
                    'is_active' => true,
                ]);
                $cityId = $city->id;
            }

            // Ensure slug is set
            if (empty($validated['slug'])) {
                $base = \Illuminate\Support\Str::slug($validated['title_en']);
                $slug = $base;
                $i = 1;
                while (IslandDestination::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $validated['slug'] = $slug;
            }

            $attrs = [
                'slug' => $validated['slug'] ?? null,
                'title_en' => $validated['title_en'],
                'title_ar' => $validated['title_ar'] ?? null,
                'description_en' => $validated['description_en'] ?? null,
                'description_ar' => $validated['description_ar'] ?? null,
                'features' => $validated['features'] ?? null,
                'features_en' => $validated['features_en'] ?? null,
                'features_ar' => $validated['features_ar'] ?? null,
                'image' => $validated['image'] ?? null,
                'price' => $validated['price'] ?? null,
                'rating' => $validated['rating'] ?? null,
                'type' => $validated['type'] ?? 'island',
                'active' => $validated['active'] ?? true,
            ];

            // Support both older schema (location_en) and newer schema (city_id)
            if (\Schema::hasColumn('island_destinations', 'city_id')) {
                $attrs['city_id'] = $cityId;
            } else {
                $attrs['location_en'] = $validated['city_name'] ?? null;
            }

            $destination = IslandDestination::create($attrs);

            return response()->json([
                'success' => true,
                'data' => $destination,
                'message' => 'Island destination created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating destination: ' . $e->getMessage()
            ], 422);
        }
    }

    public function storeLocal(Request $request)
    {
        // Reuse the same validation as store but set default type to 'local'
        $request->merge(['type' => 'local']);
        return $this->store($request);
    }

    public function update(Request $request, $id)
    {
        try {
            $destination = IslandDestination::findOrFail($id);
            
            $validated = $request->validate([
                'title_en' => 'nullable|string',
                'title_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'features' => 'nullable|array',
                'features_en' => 'nullable|array',
                'features_ar' => 'nullable|array',
                'image' => 'nullable|string',
                'price' => 'nullable|numeric',
                'rating' => 'nullable|numeric|between:0,5',
                'active' => 'nullable|boolean',
                'city_id' => 'nullable|integer|exists:cities,id',
                'city_name' => 'nullable|string',
                'slug' => 'nullable|string|unique:island_destinations,slug,' . $id,
                'type' => 'nullable|string',
            ]);

            // Handle city linkage on update
            // Normalize features arrays if uploaded as strings
            if (isset($validated['features_en']) && is_string($validated['features_en'])) {
                $decoded = json_decode($validated['features_en'], true);
                if (is_array($decoded)) $validated['features_en'] = $decoded;
            }
            if (isset($validated['features_ar']) && is_string($validated['features_ar'])) {
                $decoded = json_decode($validated['features_ar'], true);
                if (is_array($decoded)) $validated['features_ar'] = $decoded;
            }

            $cityId = $validated['city_id'] ?? $destination->city_id;
            if (empty($cityId) && !empty($validated['city_name'])) {
                $slug = \Illuminate\Support\Str::slug($validated['city_name']);
                $city = City::firstOrCreate([
                    'slug' => $slug
                ], [
                    'name' => $validated['city_name'],
                    'lang' => 'en',
                    'is_active' => true,
                ]);
                $cityId = $city->id;
            }

            $attrs = [
                'title_en' => $validated['title_en'] ?? $destination->title_en,
                'title_ar' => $validated['title_ar'] ?? $destination->title_ar,
                'description_en' => $validated['description_en'] ?? $destination->description_en,
                'description_ar' => $validated['description_ar'] ?? $destination->description_ar,
                'features' => $validated['features'] ?? $destination->features,
                'features_en' => $validated['features_en'] ?? $destination->features_en,
                'features_ar' => $validated['features_ar'] ?? $destination->features_ar,
                'image' => $validated['image'] ?? $destination->image,
                'price' => $validated['price'] ?? $destination->price,
                'rating' => $validated['rating'] ?? $destination->rating,
                'type' => $validated['type'] ?? $destination->type,
                'active' => $validated['active'] ?? $destination->active,
            ];

            if (\Schema::hasColumn('island_destinations', 'city_id')) {
                $attrs['city_id'] = $cityId;
            } else {
                $attrs['location_en'] = $validated['city_name'] ?? $destination->location_en ?? null;
            }

            $destination->update($attrs);

            return response()->json([
                'success' => true,
                'data' => $destination,
                'message' => 'Island destination updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating destination: ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $destination = IslandDestination::findOrFail($id);
            $destination->delete();

            return response()->json([
                'success' => true,
                'message' => 'Island destination deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting destination: ' . $e->getMessage()
            ], 404);
        }
    }
}
