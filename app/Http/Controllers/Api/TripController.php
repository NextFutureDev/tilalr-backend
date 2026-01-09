<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'ar');
        $type = $request->get('type');
        
        // Don't filter by lang - return ALL active trips so frontend can select the right translation
        $query = Trip::where('is_active', true);
        
        if ($type) {
            $query->where('type', $type);
        }
        
        // Newest-first: show the newest trips first (ignore manual "order").
        $trips = $query->with('city')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($trips);
    }

    public function show($slug)
    {
        $trip = Trip::where('slug', $slug)
            ->where('is_active', true)
            ->with('city')
            ->firstOrFail();
        
        return response()->json($trip);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:trips,slug',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer',
            'image' => 'nullable|string',
            'images' => 'nullable|json',
            'type' => 'nullable|string',
            'city_id' => 'nullable|exists:cities,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'order' => 'integer',
            'lang' => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);

        $trip = Trip::create($validated);
        return response()->json($trip->load('city'), 201);
    }

    public function update(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'string|max:255',
            'slug' => 'string|unique:trips,slug,' . $id,
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer',
            'image' => 'nullable|string',
            'images' => 'nullable|json',
            'type' => 'nullable|string',
            'city_id' => 'nullable|exists:cities,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'order' => 'integer',
            'lang' => 'string|max:10',
            'is_active' => 'boolean',
        ]);

        $trip->update($validated);
        return response()->json($trip->load('city'));
    }

    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();
        
        return response()->json(['message' => 'Trip deleted successfully']);
    }
}
