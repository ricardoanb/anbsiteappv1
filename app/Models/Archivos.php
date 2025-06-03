<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Archivos extends Model
{
	use HasFactory;

	protected $table = '00_archivos';

	protected $fillable = [
		'etiqueta',
		'archivo',
		'usuario',
	];

	// Acceso a usuario perteneciente
	public function usuario()
	{
		return $this->belongsTo(Usuarios::class, 'usuario');
	}
}
