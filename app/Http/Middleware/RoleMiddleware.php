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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Check if user has any of the required roles
        $userRole = $request->user()->role;
        $hasRole = false;

        foreach ($roles as $role) {
            if ($userRole === $role) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            abort(403, 'Access denied. Insufficient permissions.');
        }

        return $next($request);
    }
} 