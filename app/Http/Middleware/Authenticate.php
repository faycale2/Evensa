<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // Redirige vers la page de login
            return response()->json(['error', 'Vous devez être connecté pour accéder à cette page.']);
        }

        return $next($request);
    }
}
