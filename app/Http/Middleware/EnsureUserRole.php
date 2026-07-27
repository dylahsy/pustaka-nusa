<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();
        $allowedRoles = array_map('trim', $roles);

        if (! $user || ! in_array($user->role, $allowedRoles, true)) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}
