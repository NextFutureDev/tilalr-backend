<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Portfolio;
use App\Models\ContactInfo;
use App\Models\Training;
use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Traits\HasLocaleHandling;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use HasLocaleHandling;

    public function index(Request $request)
    {
        $this->setLocaleFromRequest($request);
        
        // Get only featured projects (max 3) for home page
        $projects = Project::featured()->latest()->take(3)->get();
        
        $portfolios = Portfolio::latest()->take(6)->get();
        $services = Service::all();
        $trainings = Training::ordered()->get();
        $teamMembers = TeamMember::with('roleRelation')->get();
        $contactInfos = ContactInfo::active()->ordered()->get();
        $heroSection = HeroSection::getActive();
        $aboutSection = AboutSection::active()->first();
        
        return view('index', compact('projects', 'portfolios', 'services', 'trainings', 'teamMembers', 'contactInfos', 'heroSection', 'aboutSection'));
    }
} 