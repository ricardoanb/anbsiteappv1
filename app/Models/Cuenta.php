<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
	protected $table = '00_cuentas';

	protected $fillable = [
		'uuid',
		'numero_cuenta',
		'nombre_cuenta',
		'saldo',
		'estado',
		'usuario_id',
		'plan_cuenta_id',
		'created_at',
	];

	public function usuario()
	{
		return $this->belongsTo(Usuarios::class, 'usuario_id');
	}

	public function planCuenta()
	{
		return $this->belongsTo(PlanCuenta::class, 'plan_cuenta_id');
	}

	public function movimientos()
	{
		return $this->HasMany(Movimientos::class, 'cuenta_id')->orderBy('id', 'DESC');
	}
}
