<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidarSerial
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$serialRecibido = $request->input('serial');
		$serialEsperado = env('LOAD_API_KEY');

		if ($serialRecibido !== $serialEsperado) {
			return response()->json([
				'mensaje' => 'Serial inválido',
			], 403);
		}

		return $next($request);
	}
}
