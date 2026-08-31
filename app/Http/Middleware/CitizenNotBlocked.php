<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CitizenNotBlocked
{
    /**
     * Immediately log out and block access for any blocked citizen.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $citizen = auth('citizen')->user();

        if ($citizen && $citizen->is_blocked) {
            auth('citizen')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $reason = $citizen->blocked_reason
                ? ' Reason: ' . $citizen->blocked_reason
                : '';

            return redirect()->route('citizen.login')
                ->with('error', 'Your account has been blocked by the administration.' . $reason);
        }

        return $next($request);
    }
}
