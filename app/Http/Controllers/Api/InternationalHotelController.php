<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InternationalHotel;
use Illuminate\Http\Request;

class InternationalHotelController extends Controller
{
    public function index()
    {
        try {
            $hotels = InternationalHotel::where('active', true)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($h) {
                    $image = $h->image ? ltrim($h->image, '/') : null;
                    if ($image) {
                        if (preg_match('/^https?:\/\//', $image)) {
                            $h->image = $image;
                        } elseif (str_starts_with($image, 'storage/') || str_starts_with($image, '/storage/')) {
                            $h->image = asset($image) . '?v=' . strtotime($h->updated_at);
                        } elseif (str_starts_with($image, 'international/') || str_starts_with($image, 'hotels/')) {
                            $h->image = asset('storage/' . $image) . '?v=' . strtotime($h->updated_at);
                        } elseif (str_starts_with($image, '/international') ) {
                            // static frontend asset path
                            $h->image = $image;
                        } else {
                            $h->image = asset('storage/hotels/' . $image) . '?v=' . strtotime($h->updated_at);
                        }
                    } else {
                        $h->image = null;
                    }
                    return $h;
                });

            return response()->json([
                'success' => true,
                'data' => $hotels,
                'message' => 'Hotels retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving hotels: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $hotel = InternationalHotel::findOrFail($id);

            $image = $hotel->image ? ltrim($hotel->image, '/') : null;
            if ($image) {
                if (preg_match('/^https?:\/\//', $image)) {
                    $hotel->image = $image;
                } elseif (str_starts_with($image, 'storage/') || str_starts_with($image, '/storage/')) {
                    $hotel->image = asset($image) . '?v=' . strtotime($hotel->updated_at);
                } elseif (str_starts_with($image, 'international/') || str_starts_with($image, 'hotels/')) {
                    $hotel->image = asset('storage/' . $image) . '?v=' . strtotime($hotel->updated_at);
                } elseif (str_starts_with($image, '/international') ) {
                    $hotel->image = $image;
                } else {
                    $hotel->image = asset('storage/hotels/' . $image) . '?v=' . strtotime($hotel->updated_at);
                }
            } else {
                $hotel->image = null;
            }

            return response()->json([
                'success' => true,
                'data' => $hotel,
                'message' => 'Hotel retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving hotel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'location_en' => 'required|string|max:255',
                'location_ar' => 'required|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'rating' => 'integer|min:1|max:5',
                'price' => 'nullable|numeric|min:0',
                'image' => 'nullable|string',
                'amenities_en' => 'nullable|array',
                'amenities_ar' => 'nullable|array',
                'active' => 'boolean',
            ]);

            $hotel = InternationalHotel::create($validated);

            return response()->json([
                'success' => true,
                'data' => $hotel,
                'message' => 'Hotel created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating hotel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $hotel = InternationalHotel::findOrFail($id);

            $validated = $request->validate([
                'name_en' => 'string|max:255',
                'name_ar' => 'string|max:255',
                'location_en' => 'string|max:255',
                'location_ar' => 'string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'rating' => 'integer|min:1|max:5',
                'price' => 'nullable|numeric|min:0',
                'image' => 'nullable|string',
                'amenities_en' => 'nullable|array',
                'amenities_ar' => 'nullable|array',
                'active' => 'boolean',
            ]);

            $hotel->update($validated);

            return response()->json([
                'success' => true,
                'data' => $hotel,
                'message' => 'Hotel updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating hotel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $hotel = InternationalHotel::findOrFail($id);
            $hotel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hotel deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting hotel: ' . $e->getMessage()
            ], 500);
        }
    }
}
