<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CitizenAuth
{
    /**
     * Redirect unauthenticated citizens to the citizen login page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth('citizen')->check()) {
            return redirect()->route('citizen.login')
                ->with('error', 'Please log in to your citizen account to continue.');
        }

        return $next($request);
    }
}
