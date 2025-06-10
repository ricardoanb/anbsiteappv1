<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stake extends Model
{
	protected $table = '00_stakes';

	protected $fillable = [
		'uuid',
		'nombre',
		'rendimiento',
		'minimo',
		'duracion'
	];

	public function usuarios()
	{
		return $this->belongsToMany(Usuarios::class, '00_stakes_usuarios', 'stake_id', 'usuario_id')
			->withPivot('uuid', 'monto')
			->withTimestamps();
	}
}
