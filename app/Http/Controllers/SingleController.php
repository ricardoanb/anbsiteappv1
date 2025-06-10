<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Http\Request;

class SingleController extends Controller
{

	// Vista de cuenta
	public function cuenta($id)
	{
		$usuario = auth('api')->user();

		$cuenta = Cuenta::where('usuario_id', $usuario->id)->where('uuid', $id)->first();
		return view('2_vistas.panel.singles.cuenta', compact('cuenta'));
	}

	// Vista de stake
	public function stake($id)
	{
		return view('2_vistas.panel.singles.cuenta');
	}
}
