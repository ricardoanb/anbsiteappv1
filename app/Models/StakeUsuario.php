<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StakeUsuario extends Model
{
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = '00_stake_usuario'; // Especificamos el nombre de la tabla

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'etiqueta',
		'monto_invertido',
		'rendimiento_obtenido',
		'fecha_inicio',
		'fecha_final',
		'estado',
		'usuario',    // ID del usuario
		'cuenta',     // ID de la cuenta
		'stake_id',   // ID del tipo de stake
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'monto_invertido' => 'decimal:2',
		'rendimiento_obtenido' => 'decimal:2',
		'fecha_inicio' => 'datetime',
		'fecha_final' => 'datetime',
	];

	/**
	 * Get the user that owns the stake.
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(Usuarios::class, 'usuario');
	}

	/**
	 * Get the account that the stake belongs to.
	 */
	public function cuenta(): BelongsTo
	{
		return $this->belongsTo(Cuenta::class, 'cuenta');
	}

	/**
	 * Get the stake type that this user stake belongs to.
	 */
	public function stakeType(): BelongsTo
	{
		return $this->belongsTo(Stake::class, 'stake_id');
	}
}
