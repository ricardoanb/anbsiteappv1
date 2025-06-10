<?php

namespace App\Http\Controllers;

use Elliptic\EC;
use kornrunner\Keccak;
use Illuminate\Http\Request;
use App\Models\WalletsUsuario;
use Illuminate\Support\Facades\Hash;

class WalletController extends Controller
{
	public function api_perfil_wallet(Request $request)
	{
		$ec = new EC('secp256k1');
		$key = $ec->genKeyPair();

		$privateKey = $key->getPrivate('hex');
		$publicKey = $key->getPublic(false, 'hex');
		$publicKeyHex = substr($publicKey, 2); // quitamos el prefijo "04"

		$hash = Keccak::hash(hex2bin($publicKeyHex), 256);
		$address = '0x' . substr($hash, -40);

		WalletsUsuario::create([
			'usuario_id' => auth('api')->user()->id,
			'direccion' => $address,
			'llave_privada_cifrada' => Hash::make($privateKey)
		]);

		return response()->json([
			'direccion' => $address,
			'mensaje' => 'Wallet creada con éxito. Guarda tu clave privada en un lugar seguro.',
			'private_key' => $privateKey // Solo si es la primera vez. Nunca mostrarla más tarde.
		]);
	}
}
