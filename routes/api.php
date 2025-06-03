<?php

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Controladores
use App\Http\Controllers\ApiController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\SystemController;

# iconos
# ❌✅🟡

# Endpoints individuales
Route::get('/', [ApiController::class, 'test'])->name('api_test');

# Grupo de endpoints con prefijo
Route::prefix('prefijo')->group(function () {
	Route::post('endpoint', [Apicontroller::class, 'endpoint'])->name('api_endpoint');	#❌
});

# Rutas de autenticación de usuario
Route::prefix('auth')->group(function () {
	Route::post('registro', [Apicontroller::class, 'registro'])->name('api_registro');					#✅
	Route::middleware('web')->post('login', [Apicontroller::class, 'login'])->name('api_login');		#✅
});

# Rutas con Session
Route::middleware('web')->group(function () {
	Route::prefix('usuario')->group(function () {
		Route::post('/crear', [Apicontroller::class, 'usuario_crear'])->name('api.usuario.crear');											#✅
		Route::post('/actualizar', [Apicontroller::class, 'usuario_actualizar'])->name('api.usuario.actualizar');						#✅
		Route::post('/actualizar-pass', [Apicontroller::class, 'usuario_actualizar_pass'])->name('api.usuario.actualizar.pass');	#✅
		Route::post('/eliminar', [Apicontroller::class, 'usuario_eliminar'])->name('api.usuario.eliminar');								#✅
	});
});

# Rutas con JWT
Route::middleware('auth:api')->prefix('v2')->group(function () {
	Route::get('/', [Apicontroller::class, 'usuario_get'])->name('api.usuario.get');											#✅

	// Cuentas
	Route::prefix('cuenta')->group(function () {
		Route::post('/crear', [Apicontroller::class, 'cuenta_crear'])->name('api.cuenta.crear');							#✅
		Route::get('/obtener', [Apicontroller::class, 'cuenta_obtener'])->name('api.cuenta.obtener');					#✅
		Route::put('/actualizar', [Apicontroller::class, 'cuenta_actualizar'])->name('api.cuenta.actualizar');		#✅
		Route::delete('/eliminar', [Apicontroller::class, 'cuenta_eliminar'])->name('api.cuenta.eliminar');			#✅
	});

	// Tarjetas
	Route::prefix('tarjeta')->group(function () {
		Route::post('/crear', [Apicontroller::class, 'tarjeta_crear'])->name('api.tarjeta.crear');						#❌
		Route::get('/obtener', [Apicontroller::class, 'tarjeta_obtener'])->name('api.tarjeta.obtener');					#❌
		Route::put('/actualizar', [Apicontroller::class, 'tarjeta_actualizar'])->name('api.tarjeta.actualizar');		#❌
		Route::delete('/eliminar', [Apicontroller::class, 'tarjeta_eliminar'])->name('api.tarjeta.eliminar');			#❌
	});

	// Transacciones
	Route::prefix('transaccion')->group(function () {
		Route::post('/crear', [Apicontroller::class, 'transaccion_crear'])->name('api.transaccion.crear');				#✅
		Route::get('/obtener', [Apicontroller::class, 'transaccion_obtener'])->name('api.transaccion.obtener');		#✅
	});

	// Stake
	Route::prefix('stake')->group(function () {
		Route::post('/crear', [Apicontroller::class, 'stake_crear'])->name('api.stake.crear');								#✅
		Route::get('/obtener', [Apicontroller::class, 'stake_obtener'])->name('api.stake.obtener');						#✅
		# El usuario no puede editar Route::put('/actualizar', [Apicontroller::class, 'stake_actualizar'])->name('api.stake.actualizar');	#🟡
		# El usuario no puede editar Route::delete('/eliminar', [Apicontroller::class, 'stake_eliminar'])->name('api.stake.eliminar');		#🟡
	});

	// Stake usuario
	Route::prefix('u_stake')->group(function () {
		Route::post('/crear', [Apicontroller::class, 'u_stake_crear'])->name('api.u_stake.crear');						#✅
		Route::get('/obtener', [Apicontroller::class, 'u_stake_obtener'])->name('api.u_stake.obtener');					#✅
		# Route::put('/actualizar', [Apicontroller::class, 'u_stake_actualizar'])->name('api.u_stake.actualizar');	#🟡
		# Route::delete('/eliminar', [Apicontroller::class, 'u_stake_eliminar'])->name('api.u_stake.eliminar');		#🟡
	});

	// KYC
	Route::prefix('kyc')->group(function () {
		Route::post('/crear', [ApiController::class, 'kyc_crear'])->name('apisystem.kyc.crear');					#✅
	});

	// System
	Route::prefix('transfer')->group(function () {
		Route::post('/crear', [ApiController::class, 'transferencia'])->name('apisystem.transferencia');				#✅
	});
});
