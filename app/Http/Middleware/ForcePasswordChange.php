<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForcePasswordChange
{
    /**
     * Redirect users who must change password to the change form.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        // Allow the password change and logout routes even when must_change_password=true
        if ($request->routeIs('password.force') || $request->routeIs('password.force.update') || $request->routeIs('logout') || $request->routeIs('password.request') || $request->routeIs('password.email')) {
            return $next($request);
        }

        if ($user->must_change_password) {
            return redirect()->route('password.force');
        }

        return $next($request);
    }
}
