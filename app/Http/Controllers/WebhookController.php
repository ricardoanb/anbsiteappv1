<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;

// Importa el WebhookController de Cashier
use App\Models\Usuarios;
use Illuminate\Support\Str;
use App\Models\CuentaPlanes;
use App\Models\TransaccionUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session; // Para tipar el objeto de sesión
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
	protected function handleCheckoutSessionCompleted(array $payload)
	{
		// El objeto de sesión de Stripe está en $payload['data']['object']
		$session = (object) $payload['data']['object']; // <--- ¡CAMBIO AQUÍ!

		// 1. Recuperar los metadatos
		$metadata = $session->metadata;

		$orderId = $metadata->order_id ?? null;
		$itemPurchased = $metadata->item_purchased ?? null;

		Log::info('Webhook personalizado: checkout.session.completed recibido.', [
			'session_id' => $session->id,
			'customer_id' => $session->customer,
			'payment_status' => $session->payment_status,
			'metadata' => (array) $metadata,
		]);

		// 2. Procesar la compra en tu base de datos
		if ($session->payment_status === 'paid') {

			switch ($metadata['func']) {
				case 'f1':
					return $this->crearCuenta($metadata);
					break;

				case 'f2':
					return $this->añadirFondos($metadata);
					break;

				default:
					# code...
					break;
			}

			return response()->json([
				'msg' => 'Todo OK',
				'metadata' => $metadata['func']
			]);
		} else {
			Log::warning("Webhook personalizado: Sesión {$session->id} completada pero no pagada o sin user_id. Estado: {$session->payment_status}");
			// No devuelvas JSON aquí.
		}

		return $this->successMethod();
	}

	public function crearCuenta($datos)
	{
		$plan = CuentaPlanes::where('stripe_price', $datos['item_purchased'])->first();

		Cuenta::create([
			'etiqueta' => Str::random(10),
			'numero_identificador' => 'ANB' . rand(1000, 9999) . rand(1000, 9999),
			'estado' => 'activa',
			'saldo' => 0,
			'plan' => $plan['id'],
			'usuario' => $datos['user_id'],
		]);

		return response()->json([
			'msg' => 'Crear cuenta',
			'usuario' => Auth::user(),
			'datos crudos' => $datos
		], 201);
	}

	public function añadirFondos($datos)
	{
		$cuenta = Cuenta::where('numero_identificador', $datos['cuenta'])->first();
		$cuenta->update([
			'saldo' => $cuenta->saldo + $datos['monto']
		]);

		$transaccion = TransaccionUsuario::create([
			'etiqueta' => Str::random(10),
			'fecha' => now(),
			'tipo' => 'deposito',
			'monto' => $datos['monto'],
			'cuenta_entrante' => $cuenta->id,
			'estado' => 'completada',
			'usuario' => $datos['user_id'],
		]);

		return response()->json([
			'msg' => 'Añadir fondos',
			'usuario' => Auth::user(),
			'datos crudos' => $datos,
			'transaccion' => $transaccion
		], 201);
	}
}
