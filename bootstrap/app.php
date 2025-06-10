<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies; // ESTA PUTA
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\Authenticate;
use Carbon\Carbon;

// Forzar Carbon en español globalmente
Carbon::setLocale('es');

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
		api: __DIR__ . '/../routes/api.php',
		commands: __DIR__ . '/../routes/console.php',
		health: '/up',
	)
	->withMiddleware(function (Middleware $middleware) {
		// 1. Confiar en el proxy (Cloudflare) para que Laravel sepa que la conexión es HTTPS.
		$middleware->trustProxies('*');

		// 2. Evitar que Laravel encripte nuestro token JWT.
		$middleware->encryptCookies(except: [
			'jwt_token',
		]);

		// 3. Asegurarnos de que nuestro middleware se ejecuta el primero para leer la cookie.
		$middleware->prepend(\App\Http\Middleware\JwtDesdeCookie::class);
	})
	->withExceptions(function (Exceptions $exceptions) {
		//
	})->create();
