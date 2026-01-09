<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'ar');
        $testimonials = Testimonial::where('lang', $lang)->where('is_active', true)->orderBy('order', 'asc')->get();
        return response()->json($testimonials);
    }

    public function show($id)
    {
        $testimonial = Testimonial::where('id', $id)->where('is_active', true)->firstOrFail();
        return response()->json($testimonial);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string',
            'company' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
            'rating' => 'integer|min:1|max:5',
            'order' => 'integer',
            'lang' => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);
        $testimonial = Testimonial::create($validated);
        return response()->json($testimonial, 201);
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $validated = $request->validate([
            'name' => 'string|max:255',
            'position' => 'nullable|string',
            'company' => 'nullable|string',
            'content' => 'string',
            'image' => 'nullable|string',
            'rating' => 'integer|min:1|max:5',
            'order' => 'integer',
            'lang' => 'string|max:10',
            'is_active' => 'boolean',
        ]);
        $testimonial->update($validated);
        return response()->json($testimonial);
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        return response()->json(['message' => 'Testimonial deleted successfully']);
    }
}