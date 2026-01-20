<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Traits\HasLocaleHandling;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use HasLocaleHandling;

    public function show(Request $request, $slug)
    {
        $this->setLocaleFromRequest($request);
        
        $service = Service::where('slug', $slug)->firstOrFail();
        return view('services.show', compact('service'));
    }
} 