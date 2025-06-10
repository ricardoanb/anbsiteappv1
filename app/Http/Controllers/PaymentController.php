<?php

namespace App\Http\Controllers;

use App\Models\PlanCuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Laravel\Cashier\Cashier;

class PaymentController extends Controller
{
	public function payment_producto(Request $request)
	{
		$campos = Validator::make($request->all(), [
			'cuenta' => 'required|string|exists:11_planes_cuentas,uuid',
			'nombre_cuenta_nueva' => 'required|string',
		]);

		if ($campos->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $campos->errors(),
			], 422);
		}

		$id_precio = PlanCuenta::where('uuid', $request['cuenta'])->first()->stripe_plan_id;

		$stripe = Cashier::stripe();
		$priceId = $id_precio;
		$usuario = auth('api')->user();

		$checkoutSession = $stripe->checkout->sessions->create([
			'payment_method_types' => ['card'],
			'line_items' => [
				[
					'price' => $priceId,
					'quantity' => 1,
				],
			],
			'mode' => 'payment',
			'customer_email' => $usuario->correo, // Add user email to checkout
			'success_url' => route('api.mensaje.200'),
			'cancel_url' => route('api.mensaje.500'),
			'metadata' => [
				'label_cuenta' => $request['nombre_cuenta_nueva'],
				'tipo_cuenta' => $request['cuenta'],
				'usuario' => $usuario->id,
				'func' => 'fn2'
			]
		]);

		return response()->json([
			'checkout_url' => $checkoutSession->url,
		]);
	}
	public function payment_dinamico(Request $request)
	{
		$campos = Validator::make($request->all(), [
			'cuenta' => 'required|string|exists:00_cuentas,numero_cuenta',
			'precio' => 'nullable|numeric|max:100',
			'usuario' => 'required|string|exists:00_usuarios,uuid',
			'custom-precio' => 'required_without:precio|nullable|numeric|max:10000000',
		]);

		if ($campos->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $campos->errors(),
			], 422);
		}

		$stripe = Cashier::stripe();
		$precio = $request->precio ?? $request->input('custom-precio');
		$token = $request->cookie('jwt_token');
		$cuenta = $request->cuenta;
		$usuario = $request->usuario;

		$checkoutSession = $stripe->checkout->sessions->create([
			'payment_method_types' => ['card'],
			'line_items' => [
				[
					'price_data' => [
						'currency' => 'eur',
						'product_data' => [
							'name' => 'Pago Dinámico',
						],
						'unit_amount' => $precio * 100, // Convert to cents
					],
					'quantity' => 1,
				],
			],
			'mode' => 'payment',
			'success_url' => route('api.mensaje.200'),
			'cancel_url' => route('api.mensaje.500'),
			'customer_email' => auth('api')->user()->correo, // Add user email to checkout
			'metadata' => [
				'usuario' => $usuario,
				'cuenta' => $cuenta,
				'monto' => $precio,
				'func' => 'f1'
			]
		]);

		return response()->json([
			'checkout_url' => $checkoutSession->url,
		]);
	}
}
