<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasPanel extends Model
{
	use HasFactory;

	protected $table = '99_categorias_panel'; // Especifica el nombre de la tabla si no sigue la convención de nombres

	protected $fillable = [
		'slug',
		'nombre',
		'vault',
		'visible'
	];

	public $timestamps = false;

	// public function plantilla()
	// {
	// 	return $this->belongsTo(Plantilla::class, 'plantilla');
	// }
}
