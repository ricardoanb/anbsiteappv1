<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class PaymentsController extends Controller
{
	public function generatelink(Request $request)
	{
		$producto = $request['stripe_price'];
		$quantity = 1;

		$checkout = Auth::user()->checkout(
			[$producto => $quantity],
			[
				'success_url' => route('panel.cuentas'),
				'cancel_url' => route('panel.inicio'),
				'metadata' => [
					'user_id'        => Auth::id(),
					'order_id'       => Str::uuid(),
					'func'		  	  => 'f1',
					'item_purchased' => "$producto",
				],
			]
		);

		// Extraemos la URL real de redirección
		$url = $checkout->toResponse($request)->getTargetUrl();

		return $url;
	}

	public function stripe_link_dinamico(Request $request)
	{
		$montoEnEuros = $request->input('monto'); // por ejemplo: 25.50
		$user	= Auth::user();

		if (!$montoEnEuros || $montoEnEuros <= 0) {
			return response()->json(['error' => 'Monto inválido'], 422);
		}

		Stripe::setApiKey(config('cashier.secret'));

		$session = StripeSession::create([
			'payment_method_types' => ['card'],
			'line_items' => [[
				'price_data' => [
					'currency'     => 'eur',
					'unit_amount'  => intval($montoEnEuros * 100), // centavos
					'product_data' => [
						'name' => 'Recarga de saldo',
					],
				],
				'quantity' => 1,
			]],
			'mode' => 'payment',
			'success_url' => $request->input('success_url', route('panel.cuentas')),
			'cancel_url' => $request->input('cancel_url', route('panel.inicio')),
			'metadata' => [
				'user_id' => $user->id,
				'order_id' => Str::uuid(),
				'func' => $request->func,
				'cuenta' => $request->cuenta,
				'monto' => $request->monto
			],
		]);

		return $session->url;
	}
}
