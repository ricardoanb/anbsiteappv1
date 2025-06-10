<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kyc;
use App\Models\Stake;
use App\Models\Cuenta;
use App\Models\Usuarios;
use App\Models\Movimientos;
use Illuminate\Support\Str;
use App\Models\StakeUsuario;
use App\Notifications\NotificacionIngresoEntrante;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NotificacionSaldoSubido;
//
use Web3p\EthereumTx\Transaction;
use kornrunner\Keccak;
use Web3p\EthereumUtil\Util;
use kornrunner\Secp256k1;

class PerfilController extends Controller
{

	// --------------------------------	//
	//				CAMBIO DE DATOS			//
	// --------------------------------	//

	/****************************** CAMBIO DATOS PERFIL */
	public function api_perfil_perfil(Request $request)
	{
		$usuario = auth('api')->user();

		# Validar campos
		$campos = Validator::make($request->all(), [
			'nombre' => 'required|string|max:50',
			'apellido_1' => 'required|string|max:50',
			'apellido_2' => 'required|string|max:50',
			// Estas validaciones solo se aplican si los campos vienen en la petición
			'correo' => 'sometimes|nullable|email|unique:00_usuarios,correo,' . auth('api')->id(),
			'nombre_usuario' => 'sometimes|nullable|string|unique:00_usuarios,nombre_usuario,' . auth('api')->id(),
		]);

		if ($campos->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $campos->errors(),
			], 422);
		}

		$campos = collect($campos->validated())
			->mapWithKeys(function ($valor, $clave) {
				// Solo aplicar ucfirst si NO es correo o nombre_usuario
				if (!in_array($clave, ['correo', 'nombre_usuario']) && is_string($valor)) {
					return [$clave => ucfirst(strtolower($valor))];
				}
				return [$clave => $valor];
			})
			->filter(fn($v) => $v !== null && $v !== '')
			->toArray();

		# Actualiza en base de datos
		$usuario->update($campos);

		# Mensaje de respuesta
		return response()->json([
			'mensaje' => 'Perfil actualizado correctamente.',
			'campos' => $campos,
		]);
	}

	/****************************** CAMBIO DE CONTRASEÑA */
	public function api_perfil_password(Request $request)
	{
		$usuario = auth('api')->user();

		# Validar campos
		$validador = Validator::make($request->all(), [
			'password_actual' => 'required|string',
			'password_nueva' => 'required|string|min:8|confirmed',
		]);

		if ($validador->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validador->errors(),
			], 422);
		}

		$datos = $validador->validated();

		# Verificar que la contraseña actual sea correcta
		if (!Hash::check($datos['password_actual'], $usuario->password)) {
			return response()->json([
				'mensaje' => 'La contraseña actual no es correcta.',
			], 403);
		}

		# Actualizar contraseña
		$usuario->update([
			'password' => bcrypt($datos['password_nueva']),
		]);

		return response()->json([
			'mensaje' => 'Contraseña actualizada correctamente.',
		]);
	}

	// --------------------------------	//
	//				KYC DE USUARIO				//
	// --------------------------------	//
	public function kyc_crear(Request $request)
	{
		$usuario = auth('api')->user();

		# Validar campos
		$validador = Validator::make($request->all(), [
			'telefono' => 'required|string|max:255',
			'fecha_nacimiento' => 'required|string|max:255',
			'pais_nacimiento' => 'required|string|max:255',
			'pais_origen' => 'required|string|max:255',
			'numero_documento' => 'required|string|max:255',
			'tipo_documento' => 'required|string|max:255',
			'direccion_postal' => 'required|string|max:255',
			'codigo_postal' => 'required|string|max:255',
			'ciudad' => 'required|string|max:255',
			'provincia' => 'required|string|max:255',
			'foto_selfie' => 'required|file|mimes:jpg,jpeg,png|max:20000',
			'anverso_documento' => 'required|file|mimes:jpg,jpeg,png|max:20000',
			'reverso_documento' => 'required|file|mimes:jpg,jpeg,png|max:20000',
		]);

		if ($validador->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validador->errors(),
			], 422);
		}

		$rutasGuardadas = [];

		foreach (['foto_selfie', 'anverso_documento', 'reverso_documento'] as $campo) {
			if ($request->hasFile($campo)) {
				$archivo = $request->file($campo);
				$ruta = $archivo->store('kyc', 'public');
				$rutasGuardadas[$campo] = $ruta;
			}
		}

		# Agregar rutas de archivos al array de datos
		$datos = array_merge($validador->validated(), $rutasGuardadas);

		# Datos incrustados
		$datos['uuid'] = Str::uuid();
		$datos['created_at'] = Carbon::now();
		$datos['estado'] = 'pendiente';
		$datos['usuario_id'] = $usuario->id;

		# Verificar si ya existe un registro KYC para el usuario
		$kycExistente = Kyc::where('usuario_id', $usuario->id)->first();

		if ($kycExistente) {
			# Actualizar el registro existente
			$kycExistente->update($datos);

			return response()->json([
				'mensaje' => 'Datos KYC actualizados correctamente.',
				'datos' => $datos,
			]);
		}

		# Crear un nuevo registro si no existe
		$kycNuevo = Kyc::create($datos);

		return response()->json([
			'mensaje' => 'Datos KYC registrados correctamente.',
			'datos' => $datos,
		]);
	}

	public function comprobar_kyc()
	{
		$usuario = auth('api')->user();

		if (!$usuario->kyc) {
			return response()->json([
				'mensaje' => 'No tienes KYC realizado, por favor rellene el formulario.'
			], 401);
		}

		if ($usuario->kyc->estado == 'pendiente') {
			return response()->json([
				'mensaje' => 'Su KYC no ha sido verificado. Por favor, espera mientras podemos verificar tu identidad.'
			], 401);
		}

		if ($usuario->kyc->estado == 'rechazado') {
			return response()->json([
				'mensaje' => 'Su KYC no ha cumplido con nuestras verificaciones, por favor rellene KYC de nuevo para poder verificar su identidad.'
			], 401);
		}
	}

	// --------------------------------	//
	//		  CREA UNA TRANSFERENCIA 		//
	// --------------------------------	//
	public function api_perfil_transferencia(Request $request)
	{
		$request->merge([
			'custom-precio' => str_replace(',', '.', $request->input('custom-precio')),
		]);

		$validator = Validator::make($request->all(), [
			'cuenta' => 'required|string|exists:00_cuentas,numero_cuenta',
			'precio' => 'nullable|numeric|max:100',
			'custom-precio' => 'required_without:precio|numeric|max:10000000',
			'cuenta_entrante' => 'required_without:wallet_externa|nullable|string|exists:00_cuentas,numero_cuenta',
			'wallet_externa' => 'required_without:cuenta_entrante|nullable|string',
		], [
			'cuenta.required' => 'Selecciona una cuenta',
			'precio.required' => 'El monto es obligatorio',
			'custom-precio.required' => 'El monto es obligatorio',
			'cuenta_entrante.required_without' => 'La cuenta de destino es obligatoria si no indicas una wallet externa.',
			'cuenta_entrante.exists' => 'La cuenta de destino no existe',
			'wallet_externa.required_without' => 'La dirección de wallet es obligatoria si no haces una transferencia interna.',
		]);

		if ($validator->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validator->errors(),
			], 422);
		}

		if ($respuestaKyc = $this->comprobar_kyc()) return $respuestaKyc;

		$usuario = auth('api')->user();
		$montoSolicitado = $request['precio'] ?? $request['custom-precio'];

		$cuenta_saliente = Cuenta::where('numero_cuenta', $request['cuenta'])
			->where('usuario_id', $usuario->id)
			->firstOrFail();

		$cuenta_entrante = $request['cuenta_entrante']
			? Cuenta::where('numero_cuenta', $request['cuenta_entrante'])->first()
			: Cuenta::where('uuid', env('CUENTA_STAKE'))->first();

		// Calcular fee solo si es wallet externa
		$fee = 0;
		if ($request['wallet_externa']) {
			$interes = $cuenta_saliente->planCuenta->interes;
			$fee = $montoSolicitado * $interes / 100 + 5;
		}

		$montoFinal = $montoSolicitado + $fee;

		if ($cuenta_saliente->saldo < $montoFinal) {
			return response()->json([
				'mensaje' => 'No tienes suficientes fondos para enviar.',
				'errores' => ['saldo' => $montoFinal],
			], 501);
		}

		// Actualizar saldos
		$cuenta_saliente->decrement('saldo', $montoFinal);
		$cuenta_entrante->increment('saldo', $montoFinal);

		if (!$request['wallet_externa']) {
			// Movimiento saliente
			Movimientos::create([
				'estado' => 'realizado',
				'uuid' => Str::uuid(),
				'usuario_id' => $usuario->id,
				'cuenta_id' => $cuenta_saliente->id,
				'tipo' => 'Transferencia',
				'assets' => json_encode([
					'origen' => $cuenta_entrante->usuario->nombre,
					'monto' => '-' . number_format($montoFinal, 2, ',', '.'),
					'tipo de transferencia' => 'Interna',
				]),
				'monto' => $montoFinal,
				'created_at' => now(),
			]);
		}

		// Movimiento entrante
		Movimientos::create([
			'estado' => 'realizado',
			'uuid' => Str::uuid(),
			'usuario_id' => $cuenta_entrante->usuario_id,
			'cuenta_id' => $cuenta_entrante->id,
			'tipo' => 'Ingreso',
			'assets' => json_encode([
				'origen' => $cuenta_saliente->usuario->nombre,
				'monto' => '+' . number_format($montoFinal, 2, ',', '.'),
				'tipo de transferencia' => 'Interna',
			]),
			'monto' => $montoFinal,
			'created_at' => now(),
		]);

		$cuenta_entrante->usuario->notify(new NotificacionIngresoEntrante());

		$respuesta = [
			'mensaje' => 'Transferencia realizada correctamente.',
			'datos' => $request->all(),
		];

		if ($request['wallet_externa']) {
			$respuesta['modal'] = true;
			$respuesta['modal_data'] = [
				'address_to' => $request['wallet_externa'],
				'monto_total' => $montoFinal,
				'cuenta_saliente' => $cuenta_saliente->numero_cuenta,
				'interes' => number_format($montoFinal, 2, ',', '.') . ' (' . $cuenta_saliente->planCuenta->interes . '%)',
			];

			// Movimiento saliente
			Movimientos::create([
				'estado' => 'pendiente',
				'uuid' => Str::uuid(),
				'usuario_id' => $usuario->id,
				'cuenta_id' => $cuenta_saliente->id,
				'tipo' => 'Retirada',
				'assets' => json_encode([
					'origen' => $cuenta_entrante->usuario->nombre,
					'monto' => '-' . number_format($montoFinal, 2, ',', '.'),
					'wallet_detino' => '-' . $request['wallet_externa'],
					'tipo de transferencia' => 'WALLET TO WALLET',
				]),
				'monto' => $montoFinal,
				'created_at' => now(),
			]);
		}

		return response()->json($respuesta);
	}


	// --------------------------------	//
	//		  		CREA UNA STAKE 			//
	// --------------------------------	//
	public function api_perfil_stake(Request $request)
	{
		$mensajes = [
			'cuenta.required' => 'Selecciona una cuenta',
			'monto.required' => 'El monto es obligatorio',
			'stake.required' => 'El stake es obligatorio',
			'stake.exists' => 'El stake no existe',
		];

		$campos = Validator::make($request->all(), [
			'cuenta' => 'required|string|exists:00_cuentas,numero_cuenta',
			'stake' => 'nullable|string|max:100',
			'monto' => 'required|numeric|max:10000000',
		], $mensajes);

		if ($campos->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $campos->errors(),
			], 422);
		}

		// Valida los datos
		$stake = Stake::where('uuid', $request['stake'])->first();
		$cuenta = Cuenta::where('numero_cuenta', $request['cuenta'])->where('usuario_id', auth('api')->user()->id)->first();
		$monto = $request['monto'];

		// Validaciones
		if ($cuenta->saldo < $monto) {
			return response()->json([
				'mensaje' => 'No tienes fondos suficientes para apostar en stake.',
			], 422);
		}

		if ($monto < $stake->minimo) {
			return response()->json([
				'mensaje' => 'La apuesta mínima son de: ' . number_format($stake->minimo),
			], 422);
		}

		# Transferencia
		$cuenta_stakes = Cuenta::where('uuid', env('CUENTA_STAKE'))->first();
		$cuenta->decrement('saldo', $monto);
		$cuenta_stakes->increment('saldo', $monto);

		# Crear stake de usaurio
		StakeUsuario::create([
			'uuid' => Str::uuid(),
			'usuario_id' => auth('api')->user()->id,
			'stake_id' => $stake->id,
			'monto' => $monto,
			'created_at' => Carbon::now(),
			'fin' => now()->addMonths((int) $stake->duracion),
		]);

		# Movimiento
		Movimientos::create([
			'estado' => 'realizado',
			'uuid' => Str::uuid(),
			'usuario_id' => auth('api')->user()->id,
			'cuenta_id' => $cuenta->id,
			'tipo' => 'Stake',
			'assets' => json_encode([
				'origen' => 'Aportación STAKE',
				'monto' => '-' . number_format($monto, 2, ',', '.'),
				'tipo de transferencia' => 'Aportación en STAKE: ' . $stake->nombre
			]),
			'monto' => $monto,
			'created_at' => Carbon::now()
		]);

		# Movimiento para el destino
		Movimientos::create([
			'estado' => 'realizado',
			'uuid' => Str::uuid(),
			'usuario_id' => $cuenta_stakes->usuario->id,
			'cuenta_id' => $cuenta_stakes->id,
			'tipo' => 'Aportación',
			'assets' => json_encode([
				'origen' => $cuenta->numero_cuenta,
				'monto' => '+' . number_format($monto, 2, ',', '.'),
				'tipo de transferencia' => 'Aportación: ' . $stake->nombre,
				'usuario' => $cuenta->usuario->uuid
			]),
			'monto' => $monto,
			'created_at' => Carbon::now()
		]);

		return response()->json([
			'mensaje' => 'Stake relizado con éxito.',
		], 200);
	}
}
