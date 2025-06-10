<?php

namespace App\Models;

use App\Models\Usuarios;
use Illuminate\Database\Eloquent\Model;

class WalletsUsuario extends Model
{
	protected $table = '22_wallets';

	protected $fillable = [
		'usuario_id',
		'direccion',
		'llave_privada_cifrada',
	];

	public function usuario()
	{
		return $this->belongsTo(Usuarios::class, 'usuario_id');
	}
}
