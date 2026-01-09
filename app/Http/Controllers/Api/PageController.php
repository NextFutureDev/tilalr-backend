<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'ar');
        $pages = Page::where('lang', $lang)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($pages);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return response()->json($page);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:pages,slug',
            'content' => 'nullable|string',
            'image' => 'nullable|string',
            'lang' => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);

        $page = Page::create($validated);
        return response()->json($page, 201);
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'string|max:255',
            'slug' => 'string|unique:pages,slug,' . $id,
            'content' => 'nullable|string',
            'image' => 'nullable|string',
            'lang' => 'string|max:10',
            'is_active' => 'boolean',
        ]);

        $page->update($validated);
        return response()->json($page);
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        
        return response()->json(['message' => 'Page deleted successfully']);
    }
}
