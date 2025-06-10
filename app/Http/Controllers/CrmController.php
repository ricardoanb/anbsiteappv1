<?php

namespace App\Http\Controllers;

use App\Models\Kyc;
use App\Models\Stake;
use App\Models\Cuenta;
use App\Models\PlanCuenta;
use App\Models\StakeUsuario;
use Illuminate\Http\Request;
use App\Models\CategoriasPanel;
use App\Models\Movimientos;
use App\Models\WalletsUsuario;

class CrmController extends Controller
{
	// ******************************** //
	//		  				CRM					 //
	// ********************************* //

	public function inicio()
	{
		$cuentas = Cuenta::where('usuario_id', auth('api')->user()->id)->get();
		$usuario = auth('api')->user();
		$movimientos = Movimientos::orderBy('id', 'DESC')->where('usuario_id', auth('api')->user()->id)->take(10)->get();
		return view('2_vistas.panel.inicio', compact('cuentas', 'usuario', 'movimientos'));
	}

	public function ajustes()
	{
		return view('2_vistas.panel.ajustes');
	}

	# Stakes
	public function stakes()
	{
		$stakes = Stake::get();
		$stake_usuarios = StakeUsuario::where('usuario_id', auth()->user()->id)->get();
		$cuentas = Cuenta::where('usuario_id', auth('api')->user()->id)->get();
		return view('2_vistas.panel.stakes', compact('stakes', 'stake_usuarios', 'cuentas'));
	}

	# Wallets
	public function wallets()
	{
		$wallets = WalletsUsuario::where('usuario_id', auth('api')->user()->id)->get();
		return view('2_vistas.panel.wallets', compact('wallets'));
	}

	# Cuentas
	public function cuentas()
	{
		$cuentas = Cuenta::where('usuario_id', auth('api')->user()->id)->get();
		return view('2_vistas.panel.cuentas', compact('cuentas'));
	}

	# KYC
	public function kyc()
	{
		$usuario = auth('api')->user();
		$kyc = Kyc::where('usuario_id', $usuario->id)->first();
		return view('2_vistas.panel.kyc', compact('kyc'));
	}

	# Añadir dinero
	public function añadir()
	{
		$usuario = auth('api')->user();

		$cuentas = Cuenta::orderBy('id', 'ASC')->where('usuario_id', auth('api')->user()->id)->get();
		return view('2_vistas.panel.añadir', compact('cuentas'));
	}

	# Enviar dinero
	public function enviar()
	{
		$usuario = auth('api')->user();

		$cuentas = Cuenta::orderBy('id', 'ASC')->where('usuario_id', auth('api')->user()->id)->get();
		return view('2_vistas.panel.enviar', compact('cuentas'));
	}

	# Enviar dinero
	public function nueva()
	{
		$usuario = auth('api')->user();

		$planes = PlanCuenta::orderBy('id', 'ASC')->get();
		return view('2_vistas.panel.nueva', compact('planes'));
	}


	public function pagina($id)
	{
		$pagina = CategoriasPanel::where('slug', $id)->first();

		if ($pagina->visible == true) {
			if ($pagina) {
				$file = '2_vistas.panel.singles.' . $pagina->vault;
				return view($file);
			} else {
				return view('2_vistas.panel.error.404');
			}
		} else {
			return view('2_vistas.panel.error.404');
		}
	}
}
