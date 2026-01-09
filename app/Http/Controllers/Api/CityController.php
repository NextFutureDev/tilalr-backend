<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'ar');
        $cities = City::where('lang', $lang)->where('is_active', true)->orderBy('order', 'asc')->get();
        return response()->json($cities);
    }

    public function show($slug)
    {
        $city = City::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return response()->json($city);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:cities,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'images' => 'nullable|json',
            'country' => 'string',
            'order' => 'integer',
            'lang' => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);
        $city = City::create($validated);
        return response()->json($city, 201);
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $validated = $request->validate([
            'name' => 'string|max:255',
            'slug' => 'string|unique:cities,slug,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'images' => 'nullable|json',
            'country' => 'string',
            'order' => 'integer',
            'lang' => 'string|max:10',
            'is_active' => 'boolean',
        ]);
        $city->update($validated);
        return response()->json($city);
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return response()->json(['message' => 'City deleted successfully']);
    }
}