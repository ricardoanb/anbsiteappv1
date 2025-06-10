<?php

use Illuminate\Http\Request;

# Controladores
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\VistaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use NotificationChannels\WebPush\PushSubscription;

// Peticiones de prueba
Route::get('/', function (Request $request) {
	return response()->json([
		'mensaje' => 'Prueba de petición GET. Con éxito!',
		'código' => 200,
	]);
})->name('api.get.test');

Route::post('/', function (Request $request) {
	return response()->json([
		'mensaje' => 'Prueba de petición POST. Con éxito!',
		'código' => 200,
		'parámetros' => $request['parametro'],
	]);
})->name('api.post.test');


// --------------------------------	//
//				 Funciones V1				//
// --------------------------------	//

Route::prefix('v1')->group(function () {

	# Testeador
	Route::get('test', function () {
		return response()->json([
			'mensaje' => 'Prueba con JWT exitosa',
			'token' => auth('api')->user(),
		]);
	});

	// **** Auth **** //
	Route::prefix('auth')->group(function () {
		Route::post('login', [ApiController::class, 'api_login'])->name('api_login');
		Route::post('registro', [ApiController::class, 'api_registro'])->name('api_registro');
		Route::post('recuperar', [ApiController::class, 'recuperar'])->name('api_recuperar');
		Route::post('resetear', [ApiController::class, 'cambiar_password'])->name('api_cambiar_password');
	});

	// **** Ajustes del usuario **** //
	Route::prefix('perfil')->middleware('auth:api')->group(function () {
		# Cambiar campos principales
		Route::put('datos_perfil', [PerfilController::class, 'api_perfil_perfil'])->name('api_perfil_perfil');
		# Cambiar contraseña
		Route::put('datos_password', [PerfilController::class, 'api_perfil_password'])->name('api_perfil_password');
		# Transferencia interna
		Route::post('transferencia', [PerfilController::class, 'api_perfil_transferencia'])->name('api.perfil.transferencia');
		# Insertar STAKE
		Route::post('stake', [PerfilController::class, 'api_perfil_stake'])->name('api.perfil.stake');
		# Crear Wallet
		Route::post('wallet', [WalletController::class, 'api_perfil_wallet'])->name('api.perfil.wallet');
	});

	// **** Ajustes del usuario **** //
	Route::prefix('kyc')->middleware('auth:api')->group(function () {
		Route::post('crear', [PerfilController::class, 'kyc_crear'])->name('api.kyc.crear');
	});

	// **** Pasarela de pago **** //
	Route::prefix('payment')->group(function () {
		Route::post('producto', [PaymentController::class, 'payment_producto'])->middleware('auth:api')->name('api.payment.producto');
		Route::post('dinamico', [PaymentController::class, 'payment_dinamico'])->middleware('auth:api')->name('api.payment.dinamico');
		Route::post('webhook', [WebhookController::class, 'handleWebhook'])->name('api.payment.webhook');
	});
});

// --------------------------------	//
//			 Funciones V1 (JWT)			//
// --------------------------------	//

Route::prefix('intranet')->middleware('auth:api')->group(function () {

	// **** Crear y editar categorías **** //
	Route::prefix('categoria')->group(function () {
		# Web
		Route::prefix('web')->group(function () {
			Route::post('crear', [SystemController::class, 'crear_categoria_web'])->name('crear_categoria_web');
			Route::delete('eliminar', [SystemController::class, 'eliminar_categoria_web'])->name('eliminar_categoria_web');
		});

		# Panel
		Route::prefix('panel')->group(function () {
			Route::post('crear', [SystemController::class, 'crear_categoria_panel'])->name('crear_categoria_panel');
			Route::delete('eliminar', [SystemController::class, 'eliminar_categoria_panel'])->name('eliminar_categoria_panel');
		});
	});

	// **** CRUD **** //
	Route::prefix('crud')->group(function () {
		# Stake
		Route::prefix('stake')->group(function () {
			Route::post('crear', [SystemController::class, 'crear_stake'])->name('crear_stake');
			Route::delete('eliminar', [SystemController::class, 'eliminar_stake'])->name('eliminar_stake');
		});

		# Plan de usuarios
		Route::prefix('planes/usuario')->group(function () {
			Route::post('crear', [SystemController::class, 'crear_plan_usuario'])->name('crear_plan_usuario');
			Route::delete('eliminar', [SystemController::class, 'eliminar_plan_usuario'])->name('eliminar_plan_usuario');
		});
	});
});


// --------------------------------	//
//			 MENSAJES API					//
// --------------------------------	//

// **** Mensajeria **** //
Route::prefix('mensajeria')->group(function () {
	Route::get('200', function () {
		return view('2_vistas.web.error.200');
	})->name('api.mensaje.200');

	Route::get('500', function () {
		return view('2_vistas.web.error.500');
	})->name('api.mensaje.500');
});

Route::middleware('auth:api')->get('/notificaciones-sin-leer', function () {
	return auth()->user()->unreadNotifications;
});
Route::middleware('auth:api')->post('/notificaciones-marcar-leidas', function () {
	auth()->user()->unreadNotifications->markAsRead();
	return response()->json(['ok' => true]);
});
