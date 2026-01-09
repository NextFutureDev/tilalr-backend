$controllers = @{
    'PageController' = @'
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
        $pages = Page::where('lang', $lang)->where('is_active', true)->orderBy('created_at', 'desc')->get();
        return response()->json($pages);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
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
'@

    'ServiceController' = @'
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
        $services = Service::where('lang', $lang)->where('is_active', true)->orderBy('order', 'asc')->get();
        return response()->json($services);
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
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
'@
}

foreach ($controller in $controllers.Keys) {
    $content = $controllers[$controller]
    $path = "app\Http\Controllers\Api\$controller.php"
    Set-Content -Path $path -Value $content -Encoding UTF8
    Write-Host "Created $controller" -ForegroundColor Green
}
