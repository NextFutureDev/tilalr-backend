<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InternationalPackage;
use Illuminate\Http\Request;

class InternationalPackageController extends Controller
{
    public function index()
    {
        try {
            $packages = InternationalPackage::where('active', true)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($p) {
                    $image = $p->image ? ltrim($p->image, '/') : null;
                    if ($image) {
                        if (preg_match('/^https?:\/\//', $image)) {
                            $p->image = $image;
                        } elseif (str_starts_with($image, 'storage/') || str_starts_with($image, '/storage/')) {
                            $p->image = asset($image) . '?v=' . strtotime($p->updated_at);
                        } elseif (str_starts_with($image, 'international/') || str_starts_with($image, 'packages/')) {
                            $p->image = asset('storage/' . $image) . '?v=' . strtotime($p->updated_at);
                        } elseif (str_starts_with($image, '/international') ) {
                            $p->image = $image;
                        } else {
                            $p->image = asset('storage/packages/' . $image) . '?v=' . strtotime($p->updated_at);
                        }
                    } else {
                        $p->image = null;
                    }
                    return $p;
                });

            return response()->json([
                'success' => true,
                'data' => $packages,
                'message' => 'Packages retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving packages: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $package = InternationalPackage::findOrFail($id);

            $image = $package->image ? ltrim($package->image, '/') : null;
            if ($image) {
                if (preg_match('/^https?:\/\//', $image)) {
                    $package->image = $image;
                } elseif (str_starts_with($image, 'storage/') || str_starts_with($image, '/storage/')) {
                    $package->image = asset($image) . '?v=' . strtotime($package->updated_at);
                } elseif (str_starts_with($image, 'international/') || str_starts_with($image, 'packages/')) {
                    $package->image = asset('storage/' . $image) . '?v=' . strtotime($package->updated_at);
                } elseif (str_starts_with($image, '/international') ) {
                    $package->image = $image;
                } else {
                    $package->image = asset('storage/packages/' . $image) . '?v=' . strtotime($package->updated_at);
                }
            } else {
                $package->image = null;
            }

            return response()->json([
                'success' => true,
                'data' => $package,
                'message' => 'Package retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving package: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'type_en' => 'required|string|max:255',
                'type_ar' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'image' => 'nullable|string',
                'duration_en' => 'nullable|string',
                'duration_ar' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'discount' => 'nullable|string',
                'features_en' => 'nullable|array',
                'features_ar' => 'nullable|array',
                'highlight_en' => 'nullable|string',
                'highlight_ar' => 'nullable|string',
                'active' => 'boolean',
            ]);

            $package = InternationalPackage::create($validated);

            return response()->json([
                'success' => true,
                'data' => $package,
                'message' => 'Package created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating package: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $package = InternationalPackage::findOrFail($id);

            $validated = $request->validate([
                'type_en' => 'string|max:255',
                'type_ar' => 'string|max:255',
                'title_en' => 'string|max:255',
                'title_ar' => 'string|max:255',
                'description_en' => 'string',
                'description_ar' => 'string',
                'image' => 'nullable|string',
                'duration_en' => 'nullable|string',
                'duration_ar' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'discount' => 'nullable|string',
                'features_en' => 'nullable|array',
                'features_ar' => 'nullable|array',
                'highlight_en' => 'nullable|string',
                'highlight_ar' => 'nullable|string',
                'active' => 'boolean',
            ]);

            $package->update($validated);

            return response()->json([
                'success' => true,
                'data' => $package,
                'message' => 'Package updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating package: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $package = InternationalPackage::findOrFail($id);
            $package->delete();

            return response()->json([
                'success' => true,
                'message' => 'Package deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting package: ' . $e->getMessage()
            ], 500);
        }
    }
}
