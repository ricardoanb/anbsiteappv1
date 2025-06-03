<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaccionUsuario extends Model
{
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = '00_transacciones_usuario'; // Especificamos el nombre de la tabla

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'etiqueta',
		'fecha',
		'tipo',
		'monto',
		'cuenta_saliente',
		'cuenta_entrante',
		'tarjeta_id',
		'estado',
		'usuario', // ID del usuario
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'fecha' => 'datetime',
		'monto' => 'decimal:2',
	];

	/**
	 * Get the user that owns the transaction.
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(Usuarios::class, 'usuario');
	}

	/**
	 * Get the outgoing account for the transaction.
	 */
	public function cuentaSaliente(): BelongsTo
	{
		return $this->belongsTo(Cuenta::class, 'cuenta_saliente');
	}

	/**
	 * Get the incoming account for the transaction.
	 */
	public function cuentaEntrante(): BelongsTo
	{
		return $this->belongsTo(Cuenta::class, 'cuenta_entrante');
	}

	/**
	 * Get the card used for the transaction.
	 */
	public function tarjeta(): BelongsTo
	{
		return $this->belongsTo(Tarjeta::class, 'tarjeta_id');
	}
}
