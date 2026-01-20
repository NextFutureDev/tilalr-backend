<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use App\Traits\HasLocaleHandling;

class TrainingController extends Controller
{
    use HasLocaleHandling;

    public function index(Request $request)
    {
        $this->setLocaleFromRequest($request);
        $trainings = Training::ordered()->get();
        return view('training.index', compact('trainings'));
    }

    public function show(Request $request, $slug)
    {
        $this->setLocaleFromRequest($request);
        
        $training = Training::where('slug', $slug)->firstOrFail();
        
        return view('training.show', compact('training'));
    }
}
