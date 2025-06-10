<?php

namespace App\Services;

use kornrunner\Keccak;
use Elliptic\EC;
use kornrunner\Secp256k1;

class WalletService
{
	public static function generarWalletEthereum()
	{
		$ec = new EC('secp256k1');
		$key = $ec->genKeyPair();

		$privateKey = $key->getPrivate('hex');
		$publicKey = $key->getPublic(false, 'hex');
		$publicKeyHex = substr($publicKey, 2);

		$hash = Keccak::hash(hex2bin($publicKeyHex), 256);
		$address = '0x' . substr($hash, -40);

		return [
			'address' => $address,
			'private_key' => $privateKey,
		];
	}
}
