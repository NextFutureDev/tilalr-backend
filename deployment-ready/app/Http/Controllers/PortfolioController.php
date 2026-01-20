<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Traits\HasLocaleHandling;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    use HasLocaleHandling;

    public function index(Request $request)
    {
        $this->setLocaleFromRequest($request);
        
        $portfolios = Portfolio::latest()->paginate(12);
        return view('portfolio.index', compact('portfolios'));
    }
} 