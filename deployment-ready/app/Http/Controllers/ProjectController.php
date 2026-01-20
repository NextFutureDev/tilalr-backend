<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Traits\HasLocaleHandling;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use HasLocaleHandling;

    public function index(Request $request)
    {
        $this->setLocaleFromRequest($request);
        
        $projects = Project::latest()->paginate(9);
        return view('projects.index', compact('projects'));
    }

    public function show(Request $request, $slug)
    {
        $this->setLocaleFromRequest($request);
        
        $project = Project::where('slug', $slug)->firstOrFail();
        return view('projects.show', compact('project'));
    }

    public function featured()
    {
        $featuredProjects = Project::featured()->latest()->limit(3)->get();
        return response()->json($featuredProjects);
    }
} 