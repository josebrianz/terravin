<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permissions
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();
        $userRole = $user->role;
        $userPermissions = $user->getPermissions();

        // Check if user has any of the required permissions
        $hasPermission = false;
        foreach ($permissions as $permission) {
            if ($user->hasPermission($permission)) {
                $hasPermission = true;
                break;
            }
        }

        if (!$hasPermission) {
            // Log the access attempt
            Log::warning('Permission denied', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $userRole,
                'user_permissions' => $userPermissions,
                'required_permissions' => $permissions,
                'request_url' => $request->fullUrl(),
                'request_method' => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Return different responses based on request type
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Access denied. Insufficient permissions.',
                    'required_permissions' => $permissions,
                    'user_role' => $userRole
                ], 403);
            }

            abort(403, 'Access denied. Insufficient permissions.');
        }

        return $next($request);
    }
} 