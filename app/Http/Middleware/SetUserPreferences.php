<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetUserPreferences
{
    public function handle(Request $request, Closure $next)
    {
        if ($user = $request->user()) {
            // Set theme
            if ($user->theme === 'dark') {
                $request->session()->put('theme', 'dark');
            } else {
                $request->session()->put('theme', 'light');
            }

            // Set locale
            App::setLocale($user->locale);
        }

        return $next($request);
    }
} 