<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TrainingController;

// Language switcher route
Route::get('/switch-language/{locale}', function (Request $request, $locale) {
    if (! in_array($locale, ['en', 'ar'])) {
        $locale = 'en';
    }

    // Store the locale in session
    session(['locale' => $locale]);
    session()->save();
    
    // Set the application locale
    App::setLocale($locale);

    // Get the current URL from the request
    $currentUrl = $request->get('current_url');
    
    if ($currentUrl) {
        // Decode and parse the URL to handle full URLs reliably
        $decoded = urldecode($currentUrl);
        $parsed = parse_url($decoded);

        // Build path+query+fragment only (ignore scheme/host)
        $path = $parsed['path'] ?? '/';
        $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
        $fragment = isset($parsed['fragment']) ? '#' . $parsed['fragment'] : '';
        $pathWithQuery = $path . $query . $fragment;

        // Normalize to start with a single slash
        if ($pathWithQuery === '') {
            $pathWithQuery = '/';
        }
        if ($pathWithQuery[0] !== '/') {
            $pathWithQuery = '/' . $pathWithQuery;
        }

        // Swap leading locale segment if present, otherwise prefix with locale root
        if (preg_match('/^\/(en|ar)(\/|$)/', $pathWithQuery)) {
            $newUrl = preg_replace('/^\/(en|ar)(?=\/|$)/', '/' . $locale, $pathWithQuery);
        } else {
            $newUrl = '/' . $locale;
        }
    } else {
        // Fallback to home page if no current_url provided
        $newUrl = '/' . $locale;
    }

    return redirect($newUrl)
        ->with('locale_changed', true)
        ->with('current_locale', $locale)
        ->cookie('locale', $locale, 60 * 24 * 30, null, null, false, false); // Unencrypted cookie
})->name('language.switch');

// English routes
Route::get('/en', [HomeController::class, 'index'])->name('en.home');
Route::get('/en/projects', [ProjectController::class, 'index'])->name('en.projects.index');
Route::get('/en/projects/{slug}', [ProjectController::class, 'show'])->name('en.projects.show');
Route::get('/en/projects/featured', [ProjectController::class, 'featured'])->name('en.projects.featured');
Route::get('/en/portfolio', [PortfolioController::class, 'index'])->name('en.portfolio.index');
Route::get('/en/training', [TrainingController::class, 'index'])->name('en.training.index');
Route::post('/en/contact', [ContactMessageController::class, 'store'])->name('en.contact.store');
Route::get('/en/services/{slug}', [ServiceController::class, 'show'])->name('en.services.show');
Route::get('/en/training/{slug}', [TrainingController::class, 'show'])->name('en.training.show');
Route::get('/en/team', [TeamController::class, 'index'])->name('en.team.index');
Route::get('/en/contact', [ContactMessageController::class, 'index'])->name('en.contact.index');

// Arabic routes
Route::get('/ar', [HomeController::class, 'index'])->name('ar.home');
Route::get('/ar/projects', [ProjectController::class, 'index'])->name('ar.projects.index');
Route::get('/ar/projects/{slug}', [ProjectController::class, 'show'])->name('ar.projects.show');
Route::get('/ar/projects/featured', [ProjectController::class, 'featured'])->name('ar.projects.featured');
Route::get('/ar/portfolio', [PortfolioController::class, 'index'])->name('ar.portfolio.index');
Route::get('/ar/training', [TrainingController::class, 'index'])->name('ar.training.index');
Route::post('/ar/contact', [ContactMessageController::class, 'store'])->name('ar.contact.store');
Route::get('/ar/services/{slug}', [ServiceController::class, 'show'])->name('ar.services.show');
Route::get('/ar/training/{slug}', [TrainingController::class, 'show'])->name('ar.training.show');
Route::get('/ar/team', [TeamController::class, 'index'])->name('ar.team.index');
Route::get('/ar/contact', [ContactMessageController::class, 'index'])->name('ar.contact.index');

// Redirect root to default locale
Route::get('/', function () {
    $locale = session('locale', 'en');
    return redirect('/' . $locale);
});



