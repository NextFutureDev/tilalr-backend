<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'ar');
        $category = $request->get('category');
        
        $query = Product::where('lang', $lang)->where('is_active', true);
        
        if ($category) {
            $query->where('category', $category);
        }
        
        $products = $query->orderBy('order', 'asc')->get();
        
        return response()->json($products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string',
            'images' => 'nullable|json',
            'category' => 'nullable|string',
            'order' => 'integer',
            'lang' => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'slug' => 'string|unique:products,slug,' . $id,
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string',
            'images' => 'nullable|json',
            'category' => 'nullable|string',
            'order' => 'integer',
            'lang' => 'string|max:10',
            'is_active' => 'boolean',
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
