<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaPlanes extends Model
{

	protected $table = '00_cuentas_planes'; // Especificamos el nombre de la tabla

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'etiqueta',
		'nombre',
		'apy',
		'fees',
		'stripe_price',
	];
}
