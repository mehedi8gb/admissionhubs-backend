<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BaseController;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleMiddleware extends BaseController
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

            // check if user is admin
            if ($user->roles->contains('name', 'admin'))
                return $next($request);

            // Check if the user was authenticated
            if (!$user) {
                return $this->sendErrorResponse('Unauthorized', 401);
            }

            // Check if the user has the specified role
            if (!$user->hasRole($role)) {
                return $this->sendErrorResponse('Forbidden', 401);
            }

            return $next($request);

        } catch (JWTException $e) {
            return $this->sendErrorResponse('Token not valid', 401);
        }
    }
}

