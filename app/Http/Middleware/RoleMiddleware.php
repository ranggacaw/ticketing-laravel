<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return $request->expectsJson() 
                ? abort(401) 
                : redirect()->route('login');
        }

        $userRole = $request->user()->role;

        foreach ($roles as $role) {
            // Check for negation (e.g., "role:!user")
            if (str_starts_with($role, '!')) {
                $forbiddenRole = substr($role, 1);
                if ($userRole === $forbiddenRole) {
                    abort(403, 'Your role is not authorized to access this page.');
                }
                // If it's a negation and it didn't match, we continue to next check
                // or eventually allow if no other restrictions hit.
                continue;
            }

            // Standard check (e.g., "role:admin")
            if ($userRole === $role) {
                return $next($request);
            }
        }

        // if we have roles specified but none matched (and no negation aborted)
        // for standard checks, we abort if none matched.
        // But if we ONLY have negations, and we are still here, we allow.
        
        $hasPositiveCheck = false;
        foreach ($roles as $role) {
            if (!str_starts_with($role, '!')) {
                $hasPositiveCheck = true;
                break;
            }
        }

        if ($hasPositiveCheck) {
            abort(403, 'Your role is not authorized to access this page.');
        }

        return $next($request);
    }
}
