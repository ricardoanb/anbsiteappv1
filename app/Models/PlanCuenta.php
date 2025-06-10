<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanCuenta extends Model
{
	protected $table = '11_planes_cuentas';

	protected $fillable = [
		'uuid',
		'tipo_cuenta',
		'stripe_plan_id',
		'precio',
		'caracteristicas',
		'interes',
	];

	protected $casts = [
		'caracteristicas' => 'array',
	];

	public function cuentas()
	{
		return $this->hasMany(Cuenta::class, 'plan_cuenta_id');
	}
}
