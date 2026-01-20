<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\Role;
use App\Traits\HasLocaleHandling;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    use HasLocaleHandling;

    public function index(Request $request)
    {
        $this->setLocaleFromRequest($request);
        
        // Get all roles for filter buttons
        $roles = Role::active()->ordered()->get();
        
        // Get filter parameter
        $roleFilter = $request->get('role', 'all');
        
        // Build query
        $query = TeamMember::with('roleRelation');
        
        // Apply role filter if not 'all'
        if ($roleFilter !== 'all') {
            $query->where('role_id', $roleFilter);
        }
        
        $teamMembers = $query->paginate(12);
        
        return view('team.index', compact('teamMembers', 'roles', 'roleFilter'));
    }
}
