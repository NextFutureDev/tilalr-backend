<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\City;
use App\Models\Trip;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'services' => Service::count(),
            'cities' => City::count(),
            'trips' => Trip::count(),
            'testimonials' => Testimonial::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
