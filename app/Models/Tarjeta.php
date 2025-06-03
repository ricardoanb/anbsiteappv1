<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarjeta extends Model
{
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = '00_tarjetas'; // Especificamos el nombre de la tabla

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'etiqueta',
		'stripe_card_id',
		'last4',
		'brand',
		'exp_month',
		'exp_year',
		'estado',
		'usuario', // ID del usuario propietario
		'cuenta',  // ID de la cuenta asociada
	];

	/**
	 * Get the user that owns the card.
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(Usuarios::class, 'usuario');
	}

	/**
	 * Get the account that the card belongs to.
	 */
	public function cuenta(): BelongsTo
	{
		return $this->belongsTo(Cuenta::class, 'cuenta');
	}

	/**
	 * Get the transactions that used this card.
	 */
	public function transacciones(): HasMany
	{
		return $this->hasMany(TransaccionUsuario::class, 'tarjeta_id');
	}
}
