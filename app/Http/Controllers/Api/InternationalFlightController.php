<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InternationalFlight;
use Illuminate\Http\Request;

class InternationalFlightController extends Controller
{
    public function index()
    {
        try {
            $flights = InternationalFlight::where('active', true)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $flights,
                'message' => 'Flights retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving flights: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $flight = InternationalFlight::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $flight,
                'message' => 'Flight retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving flight: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'airline_en' => 'required|string|max:255',
                'airline_ar' => 'required|string|max:255',
                'route_en' => 'required|string|max:255',
                'route_ar' => 'required|string|max:255',
                'departure_time' => 'required|string',
                'arrival_time' => 'required|string',
                'duration' => 'required|string',
                'stops_en' => 'required|string',
                'stops_ar' => 'required|string',
                'price' => 'nullable|numeric|min:0',
                'active' => 'boolean',
            ]);

            $flight = InternationalFlight::create($validated);

            return response()->json([
                'success' => true,
                'data' => $flight,
                'message' => 'Flight created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating flight: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $flight = InternationalFlight::findOrFail($id);

            $validated = $request->validate([
                'airline_en' => 'string|max:255',
                'airline_ar' => 'string|max:255',
                'route_en' => 'string|max:255',
                'route_ar' => 'string|max:255',
                'departure_time' => 'string',
                'arrival_time' => 'string',
                'duration' => 'string',
                'stops_en' => 'string',
                'stops_ar' => 'string',
                'price' => 'nullable|numeric|min:0',
                'active' => 'boolean',
            ]);

            $flight->update($validated);

            return response()->json([
                'success' => true,
                'data' => $flight,
                'message' => 'Flight updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating flight: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $flight = InternationalFlight::findOrFail($id);
            $flight->delete();

            return response()->json([
                'success' => true,
                'message' => 'Flight deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting flight: ' . $e->getMessage()
            ], 500);
        }
    }
}

