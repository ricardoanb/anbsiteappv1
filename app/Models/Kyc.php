<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
	protected $table = '00_kyc';

	protected $fillable = [
		'estado',
		'uuid',
		'usuario_id',
		'telefono',
		'fecha_nacimiento',
		'pais_nacimiento',
		'pais_origen',
		'numero_documento',
		'tipo_documento',
		'direccion_postal',
		'codigo_postal',
		'ciudad',
		'provincia',
		'foto_selfie',
		'anverso_documento',
		'reverso_documento',
	];

	public function usuario()
	{
		return $this->belongsTo(Usuarios::class, 'usuario_id');
	}
}
