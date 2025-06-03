<?php

namespace App\Http\Controllers;

use App\Models\Stake;
use App\Models\Cuenta;
use App\Models\Usuarios;
use App\Models\StakeUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebController extends Controller
{
	public function test()
	{
		return view('3_panel.inicio');
	}

	public function login()
	{
		return view('2_auth.login');
	}

	public function registro()
	{
		return view('2_auth.registro');
	}

	public function logout()
	{
		Auth::logout();
		return redirect()->route('login');
	}

	# Panel admin
	public function panel_inicio()
	{
		$usuario = Auth::user();

		// Carga las relaciones que son RELACIONES ELOQUENT
		$usuario->load(['cuentas', 'tarjetas', 'userStakes']);

		// Accede a patrimonio como un método, no como una relación para carga ansiosa
		// Ya que 'cuentas' está cargada, la llamada a patrimonio() no causará una nueva consulta N+1
		$patrimonio = $usuario->patrimonio(); // Llama al método para obtener el valor calculado

		// Ahora puedes pasar $usuario (con sus relaciones cargadas) y $patrimonio a tu vista
		return view('3_panel.inicio', compact('usuario', 'patrimonio'));
	}
	public function panel_tarjetas()
	{
		$usuario = Auth::user();
		return view('3_panel.tarjetas', compact('usuario'));
	}
	public function panel_cuentas()
	{
		$usuario = Auth::user();
		$usuario->load(['cuentas']);
		return view('3_panel.cuentas', compact('usuario'));
	}
	public function panel_stake()
	{
		$usuario = Auth::user();
		$usuario->load(['userStakes']);
		$cuentas = Cuenta::where('usuario', Auth::id())->get();
		$stakes = Stake::get();

		return view('3_panel.stake', compact('usuario', 'stakes', 'cuentas'));
	}
	public function panel_tarjetas_single($id)
	{
		$usuario = Auth::user();
		return view('3_panel.singles.tarjeta', compact('usuario'));
	}
	public function panel_cuentas_single($id)
	{
		$usuario = Auth::user();
		$usuario->load(['cuentas']);

		// Filtrar
		$usuario->cuentas = $usuario->cuentas->firstWhere('etiqueta', $id);
		$usuario->cuentas->load(['tarjetas']);

		return view('3_panel.singles.cuenta', compact('usuario'));
	}
	public function panel_stake_single($id)
	{
		$usuario = Auth::user();
		$stake = StakeUsuario::with(['cuenta', 'stakeType'])->where('etiqueta', $id)->first();

		return view('3_panel.singles.stake', compact('usuario', 'stake'));
	}
	public function panel_transaccion_single($id)
	{
		$usuario = Auth::user();
		return view('3_panel.singles.transaccion', compact('usuario'));
	}
	public function panel_ajustes()
	{
		return view('3_panel.ajustes');
	}
	public function panel_kyc()
	{
		$usuario = Auth::user();
		$usuario->load(['kyc']);

		return view('3_panel.kyc', compact('usuario'));
	}
	public function panel_enviar()
	{
		$cuentas = Auth::user()->cuentas;
		return view('3_panel.singles.enviar', compact('cuentas'));
	}
}
