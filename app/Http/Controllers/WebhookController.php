<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Stripe\Webhook;
use App\Models\Cuenta;
use App\Models\Usuarios;
use App\Models\Movimientos;
use App\Models\PlanCuenta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Notifications\AbonoRealizado;
use App\Notifications\NotificacionSaldoSubido;
use Stripe\Checkout\Session; // Para tipar el objeto de sesión
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
	protected function handleCheckoutSessionCompleted(array $payload)
	{
		$session = (object) $payload['data']['object'];
		$metadata = (array) ($session->metadata ?? []);

		if (($session->payment_status ?? null) === 'paid') {

			switch ($metadata['func']) {
				case 'f1':
					$this->cargarCuenta($metadata);
					break;

				case 'fn2':
					$this->crearCuenta($metadata);
					break;

				default:
					# code...
					break;
			}
		}

		return $this->successMethod(); // importante no romper esto
	}

	protected function cargarCuenta(array $datos)
	{
		$cuentaNumero = $datos['cuenta'] ?? null;
		$uuidUsuario = $datos['usuario'] ?? null;
		$monto = (float) ($datos['monto'] ?? 0);

		// Validación básica
		if (!$cuentaNumero || !$uuidUsuario || $monto <= 0) {
			Log::warning('Webhook: datos incompletos o inválidos', $datos);
			return;
		}

		// Buscar cuenta y usuario
		$cuenta = Cuenta::where('numero_cuenta', $cuentaNumero)->first();
		$usuario = Usuarios::where('uuid', $uuidUsuario)->first();

		if (!$cuenta || !$usuario) {
			Log::error('Webhook: cuenta o usuario no encontrados', compact('cuentaNumero', 'uuidUsuario'));
			return;
		}

		// Incrementar saldo
		$cuenta->increment('saldo', $monto);

		// Registrar movimiento
		Movimientos::create([
			'uuid' => Str::uuid(),
			'usuario_id' => $usuario->id,
			'cuenta_id' => $cuenta->id,
			'tipo' => 'Abono',
			'assets' => json_encode([
				'origen' => 'Compra de créditos',
				'monto' => '+' . number_format($monto, 2, ',', '.'),
				'tipo de transferencia' => 'Externas'
			]),
			'monto' => $monto,
			'created_at' => Carbon::now()
		]);

		$usuario = Cuenta::where('numero_cuenta', $cuentaNumero)->first()->usuario;
		$usuario->notify(new NotificacionSaldoSubido());
		$usuario->notify(new \App\Notifications\NotificacionPush);
	}

	protected function crearCuenta(array $datos)
	{
		$label_cuenta = $datos['label_cuenta'] ?? null;
		$tipo_cuenta = $datos['tipo_cuenta'] ?? null;
		$usuario = $datos['usuario'] ?? null;

		$plan = PlanCuenta::where('uuid', $tipo_cuenta)->first();

		Cuenta::create([
			'uuid' => Str::uuid(),
			'numero_cuenta' => '0101' . str_pad(mt_rand(0, 999999999), 12, '0', STR_PAD_LEFT),
			'nombre_cuenta' => $label_cuenta,
			'saldo' => 0,
			'estado' => 'activo',
			'usuario_id' => $usuario,
			'plan_cuenta_id' => $plan->id,
			'created_at' => Carbon::now(),
		]);

		$usuario = Cuenta::where('id', $usuario)->first()->usuario;
		$usuario->notify(new NotificacionSaldoSubido());
		$usuario->notify(new \App\Notifications\NotificacionPush);
	}
}
