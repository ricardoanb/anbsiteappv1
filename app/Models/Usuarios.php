<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importamos HasMany

class Usuarios extends Authenticatable implements JWTSubject
{
	use Notifiable;

	protected $table = '00_usuarios';

	protected $fillable = [
		'etiqueta',
		'nombre_usuario',
		'nombre',
		'apellido_1',
		'apellido_2',
		'telefono',
		'estado',
		'rol',
		'correo',
		'password',
		'avatar'
	];

	protected $hidden = [
		'password',
		'remember_token',
		'apellido_2',
		'telefono',
		'rol',
		'correo',
		'verificacion_correo',
		'created_at',
		'updated_at'
	];

	// Casteo de atributos (opcional, pero buena práctica si los tienes en la DB)
	protected $casts = [
		'email_verified_at' => 'datetime', // Si tienes esta columna para verificación de correo
		'password' => 'hashed', // Laravel 10+ hashea automáticamente los passwords al asignar
	];


	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	public function getJWTCustomClaims()
	{
		return [];
	}

	// --- Relaciones con las nuevas tablas ---

	/**
	 * Get the accounts for the user.
	 */
	public function cuentas(): HasMany
	{
		// El segundo parámetro 'usuario' es el nombre de la columna de la clave foránea en la tabla '00_cuentas'
		// que apunta al ID de esta tabla (00_usuarios).
		return $this->hasMany(Cuenta::class, 'usuario');
	}

	/**
	 * Get the cards for the user.
	 */
	public function tarjetas(): HasMany
	{
		// El segundo parámetro 'usuario' es el nombre de la columna de la clave foránea en la tabla '00_tarjetas'
		// que apunta al ID de esta tabla (00_usuarios).
		return $this->hasMany(Tarjeta::class, 'usuario');
	}

	/**
	 * Get the user stakes for the user.
	 */
	public function userStakes(): HasMany
	{
		// El segundo parámetro 'usuario' es el nombre de la columna de la clave foránea en la tabla '00_stake_usuario'
		// que apunta al ID de esta tabla (00_usuarios).
		return $this->hasMany(StakeUsuario::class, 'usuario');
	}

	/**
	 * Get the transactions for the user.
	 */
	public function transacciones(): HasMany
	{
		// El segundo parámetro 'usuario' es el nombre de la columna de la clave foránea en la tabla '00_transacciones_usuario'
		// que apunta al ID de esta tabla (00_usuarios).
		return $this->hasMany(TransaccionUsuario::class, 'usuario');
	}

	// Acceso a muchos archivos (tu relación existente)
	public function archivos()
	{
		return $this->hasMany(Archivos::class, 'usuario_id');
	}

	// Patrimonio
	public function patrimonio()
	{
		// Suma el saldo de todas las cuentas asociadas al usuario.
		return $this->cuentas()->sum('saldo');
	}

	// KYC
	public function kyc()
	{
		return $this->hasOne(TablaKyc::class, 'usuario');
	}
}
