<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

# Controladores
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\VistaController;
use App\Http\Controllers\SingleController;

Route::get('/vapid-public-key', function () {
	return config('webpush.vapid.public_key');
});

// Rutas WEB
Route::get('/', [VistaController::class, 'web_inicio'])->name('web_inicio');
Route::get('/categorias', [VistaController::class, 'web_categorias'])->name('web_categorias');
Route::get('/articulos', [VistaController::class, 'web_articulos'])->name('web_articulos');

# Rutas solitarias
Route::get('/categoria/{id}', [VistaController::class, 'web_categoria'])->name('web_categoria');
Route::get('/articulo/{id}', [VistaController::class, 'web_articulo'])->name('web_articulo');

# Rutas Login
Route::get('/login', [VistaController::class, 'web_login'])->name('login');
Route::get('/registro', [VistaController::class, 'web_registro'])->name('registro');
Route::get('/recuperar', [VistaController::class, 'web_recuperar'])->name('recuperar');
Route::get('/resetear-pass/{id}', [VistaController::class, 'web_resetear'])->name('resetear');

# Rutas AUTH
Route::prefix('auth')->group(function () {
	Route::post('login', [ApiController::class, 'api_login'])->name('api_login');
	Route::post('registro', [ApiController::class, 'api_registro'])->name('api_registro');
	Route::get('logout', [ApiController::class, 'logout'])->name('logout');
});

# Rutas Admin
Route::prefix('panel')->middleware('auth:api')->group(function () {
	Route::get('/', [CrmController::class, 'inicio'])->name('panel_inicio');
	Route::get('/ajustes', [CrmController::class, 'ajustes'])->name('panel_ajustes');
	Route::get('/kyc', [CrmController::class, 'kyc'])->name('panel_kyc');
	Route::get('/añadir', [CrmController::class, 'añadir'])->name('panel_añadir');
	Route::get('/enviar', [CrmController::class, 'enviar'])->name('panel_enviar');
	Route::get('/nueva', [CrmController::class, 'nueva'])->name('panel_nueva');

	# Stakes
	Route::get('/stakes', [CrmController::class, 'stakes'])->name('panel_stakes');
	Route::get('/stake/{id}', [SingleController::class, 'stake'])->name('panel_stake');

	# Cuentas
	Route::get('/cuentas', [CrmController::class, 'cuentas'])->name('panel_cuentas');
	Route::get('/cuenta/{id}', [SingleController::class, 'cuenta'])->name('panel_cuenta');

	# Wallets
	Route::get('/wallets', [CrmController::class, 'wallets'])->name('panel_wallets');
	Route::get('/wallet/{id}', [SingleController::class, 'wallet'])->name('panel_wallet');
});

# Rutas independientes
Route::get('/{id}', [VistaController::class, 'web_pagina'])->name('web_pagina');
