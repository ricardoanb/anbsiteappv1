<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

# Archivo de rutas WEB
Route::get('/login', [WebController::class, 'login'])->name('login');
Route::get('/registro', [WebController::class, 'registro'])->name('web_registro');
Route::get('/logout', [WebController::class, 'logout'])->name('web_logout');

# Panel (ADMIN)
Route::middleware('auth:web')->prefix('panel')->group(function () {
	Route::get('/', [WebController::class, 'panel_inicio'])->name('panel.inicio');	#✅
	Route::get('/tarjetas', [WebController::class, 'panel_tarjetas'])->name('panel.tarjetas');	#✅
	Route::get('/cuentas', [WebController::class, 'panel_cuentas'])->name('panel.cuentas');	#✅
	Route::get('/stake', [WebController::class, 'panel_stake'])->name('panel.stake');	#✅
	Route::get('/tarjeta/{id}', [WebController::class, 'panel_tarjetas_single'])->name('panel.tarjeta.single');	#✅
	Route::get('/cuenta/{id}', [WebController::class, 'panel_cuentas_single'])->name('panel.cuenta.single');	#✅
	Route::get('/stake/{id}', [WebController::class, 'panel_stake_single'])->name('panel.stake.single');	#✅
	Route::get('/transaccion/{id}', [WebController::class, 'panel_transaccion_single'])->name('panel.transaccion');	#✅
	Route::get('/kyc', [WebController::class, 'panel_kyc'])->name('panel.kyc');	#✅
	Route::get('/ajustes', [WebController::class, 'panel_ajustes'])->name('panel.ajustes');	#✅
});

Route::middleware('auth:web')->prefix('panel/window')->group(function () {
	Route::get('/enviar', [WebController::class, 'panel_enviar'])->name('panel.enviar');	#✅
	Route::get('/whitelist', [WebController::class, 'panel_whitelist'])->name('panel.whitelist');	#✅
});
