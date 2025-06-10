<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 1. PlanUsuario
class PlanUsuario extends Model
{
	protected $table = '11_planes_usuario';

	protected $fillable = [
		'uuid',
		'plan_nombre',
		'plan_stripe',
		'plan_precio',
		'plan_caracteristicas',
	];

	protected $casts = [
		'plan_caracteristicas' => 'array',
	];

	public function usuarios()
	{
		return $this->hasMany(Usuarios::class, 'plan_usuario_id');
	}
}
