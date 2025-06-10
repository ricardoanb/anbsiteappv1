<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class Usuarios extends Authenticatable implements JWTSubject
{
	use Notifiable, HasPushSubscriptions;

	// Define la tabla asociada si no sigue la convención de nombres
	protected $table = '00_usuarios';

	// Campos que se pueden asignar masivamente
	protected $fillable = [
		'uuid',
		'etiqueta',
		'nombre',
		'apellido_1',
		'apellido_2',
		'nombre_usuario',
		'correo',
		'password',
		'plan_usuario_id',
	];

	// Ocultar campos sensibles al serializar el modelo
	protected $hidden = [
		'password',
		'remember_token',
	];

	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	public function getJWTCustomClaims()
	{
		return [];
	}

	public function plan()
	{
		return $this->belongsTo(PlanUsuario::class, 'plan_usuario_id');
	}

	public function planesCuentas()
	{
		return $this->hasMany(PlanCuenta::class, 'usuario_id');
	}

	public function cuentas()
	{
		return $this->hasMany(Cuenta::class, 'usuario_id');
	}

	public function kyc()
	{
		return $this->hasOne(Kyc::class, 'usuario_id');
	}

	public function stakes()
	{
		return $this->belongsToMany(Stake::class, '00_stakes_usuarios', 'usuario_id', 'stake_id')
			->withPivot('monto')
			->withTimestamps();
	}

	public function saldoTotal()
	{
		return $this->cuentas()->sum('saldo');
	}

	public function invertidoStake()
	{
		return $this->stakes()->sum('monto');
	}
}
