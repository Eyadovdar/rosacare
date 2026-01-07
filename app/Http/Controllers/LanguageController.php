<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        $supportedLocales = ['ar', 'en'];
        
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale', 'ar');
        }

        // Set locale in session
        Session::put('locale', $locale);
        
        // Set locale in app
        App::setLocale($locale);

        // Get the previous URL or default to home
        $previousUrl = $request->header('Referer');
        
        // If there's a previous URL, parse it to get the path
        if ($previousUrl) {
            $parsedUrl = parse_url($previousUrl);
            $path = $parsedUrl['path'] ?? '/';
            $query = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
            
            // Remove any locale prefix from the path
            $path = preg_replace('#^/(ar|en)(/|$)#', '/', $path);
            $path = $path ?: '/';
            
            return Redirect::to($path . $query);
        }
        
        // Fallback to home
        return Redirect::to(route('home'));
    }
}

