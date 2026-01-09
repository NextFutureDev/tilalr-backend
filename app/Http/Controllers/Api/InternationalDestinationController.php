<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InternationalDestination;
use Illuminate\Http\Request;

class InternationalDestinationController extends Controller
{
    public function index()
    {
        try {
            $destinations = InternationalDestination::where('active', true)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($d) {
                    $image = $d->image ? ltrim($d->image, '/') : null;
                    if ($image) {
                        if (preg_match('/^https?:\/\//', $image)) {
                            $d->image = $image;
                        } elseif (str_starts_with($image, 'storage/') || str_starts_with($image, '/storage/')) {
                            $d->image = asset($image) . '?v=' . strtotime($d->updated_at);
                        } elseif (str_starts_with($image, 'international/') || str_starts_with($image, 'destinations/')) {
                            $d->image = asset('storage/' . $image) . '?v=' . strtotime($d->updated_at);
                        } elseif (str_starts_with($image, '/international') ) {
                            $d->image = $image;
                        } else {
                            $d->image = asset('storage/destinations/' . $image) . '?v=' . strtotime($d->updated_at);
                        }
                    } else {
                        $d->image = null;
                    }
                    return $d;
                });

            return response()->json([
                'success' => true,
                'data' => $destinations,
                'message' => 'Destinations retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving destinations: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $destination = InternationalDestination::findOrFail($id);

            $image = $destination->image ? ltrim($destination->image, '/') : null;
            if ($image) {
                if (preg_match('/^https?:\/\//', $image)) {
                    $destination->image = $image;
                } elseif (str_starts_with($image, 'storage/') || str_starts_with($image, '/storage/')) {
                    $destination->image = asset($image) . '?v=' . strtotime($destination->updated_at);
                } elseif (str_starts_with($image, 'international/') || str_starts_with($image, 'destinations/')) {
                    $destination->image = asset('storage/' . $image) . '?v=' . strtotime($destination->updated_at);
                } elseif (str_starts_with($image, '/international') ) {
                    $destination->image = $image;
                } else {
                    $destination->image = asset('storage/destinations/' . $image) . '?v=' . strtotime($destination->updated_at);
                }
            } else {
                $destination->image = null;
            }

            return response()->json([
                'success' => true,
                'data' => $destination,
                'message' => 'Destination retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving destination: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'image' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'active' => 'boolean',
            ]);

            $destination = InternationalDestination::create($validated);

            return response()->json([
                'success' => true,
                'data' => $destination,
                'message' => 'Destination created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating destination: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $destination = InternationalDestination::findOrFail($id);

            $validated = $request->validate([
                'name_en' => 'string|max:255',
                'name_ar' => 'string|max:255',
                'description_en' => 'string',
                'description_ar' => 'string',
                'image' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'active' => 'boolean',
            ]);

            $destination->update($validated);

            return response()->json([
                'success' => true,
                'data' => $destination,
                'message' => 'Destination updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating destination: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $destination = InternationalDestination::findOrFail($id);
            $destination->delete();

            return response()->json([
                'success' => true,
                'message' => 'Destination deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting destination: ' . $e->getMessage()
            ], 500);
        }
    }
}
