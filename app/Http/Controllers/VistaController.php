<?php

namespace App\Http\Controllers;

use App\Models\CategoriasWeb;
use App\Models\PasswordToken;
use Illuminate\Http\Request;

class VistaController extends Controller
{
	public function web_inicio()
	{
		return view('2_vistas.web.inicio');
	}

	public function web_categorias()
	{
		return view('2_vistas.web.categorias');
	}

	public function web_articulos()
	{
		return view('2_vistas.web.articulos');
	}

	public function web_categoria($id)
	{
		return view('2_vistas.web.categoria');
	}

	public function web_articulo($id)
	{
		return view('2_vistas.web.articulo');
	}

	// ******************************** //
	//		  				AUTH					//
	// ******************************** //

	# Iniciar sesión
	public function web_login()
	{
		return view('2_vistas.auth.login');
	}

	# Registrarse
	public function web_registro()
	{
		return view('2_vistas.auth.registro');
	}

	# Recuperación de contraseña
	public function web_recuperar()
	{
		return view('2_vistas.auth.recuperar');
	}

	# Recuperación de contraseña
	public function web_resetear($id)
	{
		$token = PasswordToken::where('token', $id)->first();
		if ($token) {
			return view('2_vistas.auth.resetear', compact('token'));
		} else {
			return redirect('/');
		}
	}

	// ******************************** //
	//		  PAGINAS INDEPENDIENTES		//
	// ******************************** //

	# Página independiente
	public function web_pagina($id)
	{
		$pagina = CategoriasWeb::where('slug', $id)->first();

		if (!$pagina) {
			return view('2_vistas.web.error.404');
		}

		$load = '2_vistas.web.singles.' . $pagina['vault'];
		return view($load);
	}
}
