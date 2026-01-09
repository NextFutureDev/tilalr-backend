<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'ar');
        $teamMembers = TeamMember::where('lang', $lang)->where('is_active', true)->orderBy('order', 'asc')->get();
        return response()->json($teamMembers);
    }

    public function show($id)
    {
        $teamMember = TeamMember::where('id', $id)->where('is_active', true)->firstOrFail();
        return response()->json($teamMember);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string',
            'bio' => 'nullable|string',
            'image' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'social_links' => 'nullable|json',
            'order' => 'integer',
            'lang' => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);
        $teamMember = TeamMember::create($validated);
        return response()->json($teamMember, 201);
    }

    public function update(Request $request, $id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $validated = $request->validate([
            'name' => 'string|max:255',
            'position' => 'string',
            'bio' => 'nullable|string',
            'image' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'social_links' => 'nullable|json',
            'order' => 'integer',
            'lang' => 'string|max:10',
            'is_active' => 'boolean',
        ]);
        $teamMember->update($validated);
        return response()->json($teamMember);
    }

    public function destroy($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $teamMember->delete();
        return response()->json(['message' => 'Team member deleted successfully']);
    }
}