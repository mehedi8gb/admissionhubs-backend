<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return JsonResponse|void
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        try {
            // Attempt to authenticate the user using JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Check if the user was authenticated
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // Check if the user has the specified role
            if (!$user->hasRole($role)) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            return $next($request);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not valid'], 401);
        }
    }
}

