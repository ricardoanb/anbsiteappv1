<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StakeUsuario extends Pivot
{
	protected $table = '00_stakes_usuarios';

	protected $fillable = [
		'uuid',
		'usuario_id',
		'stake_id',
		'monto',
		'fin'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuarios::class, 'usuario_id');
	}

	public function stake()
	{
		return $this->belongsTo(Stake::class, 'stake_id');
	}
}
