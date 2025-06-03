<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuenta extends Model
{
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = '00_cuentas'; // Especificamos el nombre de la tabla

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'etiqueta',
		'numero_identificador',
		'estado',
		'saldo',
		'usuario', // ID del usuario propietario
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'saldo' => 'decimal:2', // Asegura que el saldo se maneje como decimal con 2 dígitos
	];

	/**
	 * Get the user that owns the account.
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(Usuarios::class, 'usuario');
	}

	/**
	 * Get the cards for the account.
	 */
	public function tarjetas(): HasMany
	{
		return $this->hasMany(Tarjeta::class, 'cuenta');
	}

	/**
	 * Get the user stakes for the account.
	 */
	public function userStakes(): HasMany
	{
		return $this->hasMany(StakeUsuario::class, 'cuenta');
	}

	/**
	 * Get the outgoing transactions for the account.
	 */
	public function transaccionesSalientes(): HasMany
	{
		return $this->hasMany(TransaccionUsuario::class, 'cuenta_saliente');
	}

	/**
	 * Get the incoming transactions for the account.
	 */
	public function transaccionesEntrantes(): HasMany
	{
		return $this->hasMany(TransaccionUsuario::class, 'cuenta_entrante');
	}

	// --- Método para obtener todas las transacciones (salientes y entrantes) ---
	public function allTransactions()
	{
		// Une las colecciones de transacciones salientes y entrantes
		// y opcionalmente las ordena por fecha
		return $this->transaccionesSalientes
			->merge($this->transaccionesEntrantes)
			->sortByDesc('id'); // O sortBy('fecha') para ascendente
	}
}
