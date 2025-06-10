<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
	protected $table = '22_movimientos_cuenta';

	protected $fillable = [
		'uuid',
		'usuario_id',
		'cuenta_id',
		'tipo',
		'monto',
		'assets',
		'created_at',
		'estado'
	];

	public $timestamps = false;

	public function usuario()
	{
		return $this->belongsTo(Usuarios::class, 'usuario_id', 'id');
	}

	public function cuenta()
	{
		return $this->HasMany(Cuenta::class, 'id', 'cuenta_id');
	}
}
