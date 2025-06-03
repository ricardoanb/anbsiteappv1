<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stake extends Model
{
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = '00_stakes'; // Especificamos el nombre de la tabla

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'etiqueta',
		'nombre',
		'rendimiento',
		'minimo',
		'moneda',
		'icono',
		'estado',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'rendimiento' => 'decimal:2',
		'minimo' => 'decimal:2',
	];

	/**
	 * Get the user stakes for this stake type.
	 */
	public function userStakes(): HasMany
	{
		return $this->hasMany(StakeUsuario::class, 'stake_id');
	}
}
