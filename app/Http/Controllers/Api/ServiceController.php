<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'ar');

        // Build a query and only apply ordering if 'order' column exists (backwards compatibility)
        $query = Service::where('is_active', true);

        if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'lang')) {
            $query->where('lang', $lang);
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'order')) {
            $query->orderBy('order', 'asc');
        }

        $services = $query->get();

        return response()->json($services);
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return response()->json($service);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:services,slug',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'icon' => 'nullable|string',
            'image' => 'nullable|string',
            'order' => 'integer',
            'lang' => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);

        $service = Service::create($validated);
        return response()->json($service, 201);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'string|max:255',
            'slug' => 'string|unique:services,slug,' . $id,
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'icon' => 'nullable|string',
            'image' => 'nullable|string',
            'order' => 'integer',
            'lang' => 'string|max:10',
            'is_active' => 'boolean',
        ]);

        $service->update($validated);
        return response()->json($service);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        
        return response()->json(['message' => 'Service deleted successfully']);
    }
}
