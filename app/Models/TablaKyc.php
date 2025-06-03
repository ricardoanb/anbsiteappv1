<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablaKyc extends Model
{
	protected $table = '00_kyc_usuarios'; // Especificamos el nombre de la tabla

	protected $fillable = [
		'etiqueta',
		'nombre_completo',
		'fecha_nacimiento',
		'tipo_documento',
		'numero_documento',
		'pais_emision',
		'direccion',
		'codigo_postal',
		'ciudad',
		'provincia',
		'pais_residencia',
		'telefono',
		'correo_electronico',
		'fuente_fondos',
		'documento_frontal',
		'documento_trasero',
		'selfie_documento',
		'estado',
		'usuario'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuarios::class, 'usuario');
	}
}
