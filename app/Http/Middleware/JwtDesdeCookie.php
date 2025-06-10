<?php

namespace App\Http\Middleware;

use Closure;

class JwtDesdeCookie
{
	public function handle($request, Closure $next)
	{
		// Log para ver todas las cookies que llegan a Laravel
		Log::info('Petición a: ' . $request->path());
		Log::info('Cookies recibidas por Laravel:', $request->cookies->all());

		if (!$request->bearerToken() && $request->hasCookie('jwt_token')) {
			Log::info('Cookie jwt_token encontrada. Añadiendo cabecera Authorization.');
			$token = $request->cookie('jwt_token');
			$request->headers->set('Authorization', 'Bearer ' . $token);
		} else {
			Log::info('Cookie jwt_token NO encontrada o ya existe un Bearer Token.');
		}

		return $next($request);
	}
}
