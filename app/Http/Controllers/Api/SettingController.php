<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $group = $request->get('group');
        $query = Setting::query();
        if ($group) { $query->where('group', $group); }
        $settings = $query->get()->pluck('value', 'key');
        return response()->json($settings);
    }

    public function show($key)
    {
        $setting = Setting::where('key', $key)->firstOrFail();
        return response()->json($setting);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:settings,key',
            'value' => 'nullable|string',
            'type' => 'string',
            'group' => 'nullable|string',
        ]);
        $setting = Setting::create($validated);
        return response()->json($setting, 201);
    }

    public function update(Request $request, $key)
    {
        $setting = Setting::where('key', $key)->firstOrFail();
        $validated = $request->validate([
            'value' => 'nullable|string',
            'type' => 'string',
            'group' => 'nullable|string',
        ]);
        $setting->update($validated);
        return response()->json($setting);
    }

    public function destroy($key)
    {
        $setting = Setting::where('key', $key)->firstOrFail();
        $setting->delete();
        return response()->json(['message' => 'Setting deleted successfully']);
    }
}