<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class JwtDesdeCookie
{
	public function handle($request, Closure $next)
	{
		if (!$request->bearerToken() && $request->hasCookie('jwt_token')) {
			$token = $request->cookie('jwt_token');
			$request->headers->set('Authorization', 'Bearer ' . $token);
		}
		return $next($request);
	}
}
