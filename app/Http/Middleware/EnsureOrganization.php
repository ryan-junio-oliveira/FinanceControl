<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureOrganization
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || empty($user->organization_id)) {
            return redirect()->back()->with('warning', 'Você precisa selecionar ou criar uma organização antes de acessar esta área.');
        }

        return $next($request);
    }
}
