<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stake;
use App\Models\Cuenta;
use App\Models\CuentaPlanes;
use App\Models\Tarjeta;
use App\Models\TablaKyc;
use App\Models\Usuarios;
use Illuminate\Support\Str;
//
use App\Models\StakeUsuario;
use Illuminate\Http\Request;
use App\Models\TransaccionUsuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Para reglas de unicidad excluyendo el propio ID

class ApiController extends Controller
{
	public function test()
	{
		return 'API inicio.';
	}

	public function endpoint(Request $request)
	{
		return response()->json([
			'msg' => 'Endpoint',
			'request' => $request['nombre']
		], 200);
	}

	/* --------------------- */
	//				AUTH			 */
	///////////////////////////

	function generarEtiquetas($longitud = 5)
	{
		do {
			$base = base_convert((string) microtime(true) * 10000, 10, 36); // convierte a base36
			$etiqueta = strtoupper(substr($base, -$longitud)); // toma últimos caracteres
		} while (Usuarios::where('etiqueta', $etiqueta)->exists());

		return $etiqueta;
	}

	public function registro(Request $request)
	{
		$mensajes = [
			'nombre.required' => 'El nombre es obligatorio.',
			'nombre.string' => 'El nombre debe ser una cadena de texto.',
			'nombre.max' => 'El nombre no debe tener más de 30 caracteres.',
			'apellido_1.required' => 'El primer apellido es obligatorio.',
			'apellido_1.string' => 'El primer apellido debe ser una cadena de texto.',
			'apellido_1.max' => 'El primer apellido no debe tener más de 25 caracteres.',
			'apellido_2.required' => 'El segundo apellido es obligatorio.',
			'apellido_2.string' => 'El segundo apellido debe ser una cadena de texto.',
			'apellido_2.max' => 'El segundo apellido no debe tener más de 25 caracteres.',
			'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
			'nombre_usuario.string' => 'El nombre de usuario debe ser una cadena de texto.',
			'nombre_usuario.max' => 'El nombre de usuario no debe tener más de 15 caracteres.',
			'nombre_usuario.unique' => 'Este nombre de usuario ya está en uso.', // ¡Añadido!
			'telefono.required' => 'El teléfono es obligatorio.',
			'telefono.string' => 'El teléfono debe ser una cadena de texto.',
			'telefono.max' => 'El teléfono no debe tener más de 10 caracteres.',
			'correo.required' => 'El correo electrónico es obligatorio.',
			'correo.email' => 'El correo electrónico no tiene un formato válido.',
			'correo.max' => 'El correo electrónico no debe tener más de 100 caracteres.',
			'correo.unique' => 'Este correo electrónico ya está registrado.', // ¡Añadido!
			'password.required' => 'La contraseña es obligatoria.',
			'password.confirmed' => 'La confirmación de la contraseña no coincide.',
			'password.string' => 'La contraseña debe ser una cadena de texto.',
			'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
			'password.max' => 'La contraseña no debe tener más de 20 caracteres.',
			'contrato.required' => 'Debes aceptar los términos y condiciones para continuar',
		];

		try {
			$validacion = $request->validate([
				'nombre' => 'required|string|max:30',
				'apellido_1' => 'required|string|max:25',
				'apellido_2' => 'required|string|max:25',
				'nombre_usuario' => 'required|string|max:15|unique:00_usuarios', // ¡Añadido unique!
				'telefono' => 'required|string|max:10',
				'correo' => 'required|email|max:100|unique:00_usuarios', // ¡Añadido unique!
				'password' => 'required|confirmed|string|min:8|max:20',
				'contrato' => 'required',
			], $mensajes);

			$usuario = Usuarios::create([
				'etiqueta' => $this->generarEtiquetas(5), // Asumo que tienes esta función en tu controlador
				'nombre' => $validacion['nombre'],
				'apellido_1' => $validacion['apellido_1'],
				'apellido_2' => $validacion['apellido_2'],
				'nombre_usuario' => $validacion['nombre_usuario'],
				'telefono' => $validacion['telefono'],
				'correo' => $validacion['correo'],
				'password' => Hash::make($validacion['password']),
				'estado' => 'activo',
				'rol' => 'usuario',
				'avatar' => '/storage/avatars/avatar.png'
			]);

			// crea una cuenta
			Cuenta::create([
				'etiqueta' => Str::uuid(),
				'numero_identificador' => random_int(1000, 9999) . '-' . random_int(1000, 9999) . '-' . random_int(1000, 9999) . '-' . random_int(1000, 9999),
				'estado' => $validacion['estado'] ?? 'activa',
				'saldo' => $validacion['saldo'] ?? 0.00,
				'usuario' => $usuario->id,
			]);

			return response()->json([
				'usuario' => $usuario,
				'msg' => 'Usuario creado con éxito.',
				'code' => 201 // Código 201 para "Creado" es más semántico para una creación exitosa
			], 201);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json([
				'errors' => $e->validator->errors()->getMessages(),
				'msg' => 'Error de validación.',
				'code' => 422 // Código 422 para "Unprocessable Entity" indica errores de validación
			], 422);
		} catch (\Exception $e) {
			// Captura cualquier otro error que pueda ocurrir (ej. error de base de datos)
			return response()->json([
				'msg' => 'Ha ocurrido un error inesperado.',
				'error' => $e->getMessage(), // Útil para depuración, pero no mostrar en producción
				'code' => 500 // Código 500 para "Internal Server Error"
			], 500);
		}
	}

	public function login(Request $request)
	{
		$credentials = $request->only('correo', 'password');

		if (!$token = auth('api')->attempt($credentials)) {
			return response()->json(['error' => 'Credenciales inválidas'], 401);
		}

		// Autenticación exitosa para la API (JWT)
		$user = auth('api')->user();

		// Iniciar sesión para la sesión web (si aún no lo has hecho)
		Auth::login($user);
		$request->session()->regenerate();

		Usuarios::where('id', Auth::user()->id)->update([
			'remember_token' => $token
		]);

		return response()->json([
			'code' => 200,
			'token' => $token,
			'redirect_url' => route('panel.inicio') // O la URL a la que quieres redirigir
		]);
	}

	/* ----- USUARIOS ------ */

	public function usuario_crear(Request $request)
	{
		$usuario = Auth::user();
		return $usuario;
	}

	public function usuario_actualizar(Request $request)
	{
		$mensajes = [
			'nombre.string' => 'El nombre tiene que ser un texto.',
			'nombre.max' => 'El nombre no debe superar los 30 caracteres.',
			'apellido_1.string' => 'El primer apellido tiene que ser un texto.',
			'apellido_1.max' => 'El primer apellido no debe superar los 25 caracteres.',
			'apellido_2.string' => 'El segundo apellido tiene que ser un texto.',
			'apellido_2.max' => 'El segundo apellido no debe superar los 25 caracteres.',
			'avatar.mimes' => 'El avatar debe ser una imagen de tipo PNG, JPG, GIF o JPEG.',
			'avatar.max' => 'El tamaño máximo del avatar es de 51200 KB (50 MB).',
			'correo.string' => 'El correo tiene que ser un texto.',
			'correo.max' => 'El correo no debe superar los 100 caracteres.',
			'correo.unique' => 'El correo ya está escogido.',
			'nombre_usuario.string' => 'El nombre de usuario tiene que ser un texto.',
			'nombre_usuario.max' => 'El nombre de usuario no debe superar los 20 caracteres.',
			'nombre_usuario.unique' => 'El nombre de usuario ya está escogido.',
		];

		try {
			$rules = [
				'avatar' => 'sometimes|mimes:png,gif,jpeg,jpg|max:51200',
				'nombre' => 'sometimes|string|max:30',
				'apellido_1' => 'sometimes|string|max:25',
				'apellido_2' => 'sometimes|string|max:25',
				'correo' => 'sometimes|string|max:100|nullable|unique:00_usuarios,correo,' . Auth::id(),
				'nombre_usuario' => 'sometimes|string|max:20|nullable|unique:00_usuarios,nombre_usuario,' . Auth::id(),
			];

			$validacion = $request->validate($rules, $mensajes);

			$usuarioData = [];

			if (isset($validacion['nombre'])) {
				$usuarioData['nombre'] = $validacion['nombre'];
			}
			if (isset($validacion['apellido_1'])) {
				$usuarioData['apellido_1'] = $validacion['apellido_1'];
			}
			if (isset($validacion['apellido_2'])) {
				$usuarioData['apellido_2'] = $validacion['apellido_2'];
			}
			if (isset($validacion['correo']) && $validacion['correo'] !== '') {
				$usuarioData['correo'] = $validacion['correo'];
			}
			if (isset($validacion['nombre_usuario']) && $validacion['nombre_usuario'] !== '') {
				$usuarioData['nombre_usuario'] = $validacion['nombre_usuario'];
			}

			if ($request->hasFile('avatar')) {
				$avatarFile = $request->file('avatar');
				$filename = Str::uuid() . '.' . $avatarFile->getClientOriginalExtension();
				$path = $avatarFile->storeAs('avatars', $filename, 'public');

				if (Auth::user()->avatar) {
					Storage::disk('public')->delete('avatars/' . basename(Auth::user()->avatar));
				}
				$usuarioData['avatar'] = Storage::url($path);
			}

			if (!empty($usuarioData)) {
				Usuarios::where('id', Auth::id())->update($usuarioData);
				return response()->json(['msg' => 'Cambios realizados', 'code' => 200], 200);
			} else {
				return response()->json(['msg' => 'No se realizaron cambios', 'code' => 200], 200);
			}
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function usuario_actualizar_pass(Request $request)
	{
		$mensajes = [
			'current_password.required' => 'La contraseña actual es obligatoria.',
			'current_password.current_password' => 'La contraseña actual es incorrecta.',
			'password.required' => 'La nueva contraseña es obligatoria.',
			'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
			'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
		];

		try {
			$validacion = $request->validate([
				'current_password' => 'required|current_password',
				'password' => 'required|min:8|confirmed',
			], $mensajes);

			$user = Usuarios::find(Auth::id()); // Primero recupera el usuario por su ID
			$user->password = Hash::make($request->password);
			$user->save(); // Luego guarda el modelo actualizado

			return response()->json(['msg' => 'Contraseña actualizada con éxito.', 'code' => 200], 200);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json([
				'errors' => $e->validator->errors()->getMessages(),
				'msg' => 'Error al cambiar la contraseña.',
				'code' => 422
			], 422);
		} catch (\Exception $e) {
			return response()->json([
				'msg' => 'Ha ocurrido un error inesperado al cambiar la contraseña.',
				'error' => $e->getMessage(),
				'code' => 500
			], 500);
		}
	}

	public function usuario_eliminar(Request $request)
	{
		$usuario = Auth::user();
		return $usuario;
	}

	/* ----- CUENTA ------ */

	public function cuenta_crear(Request $request)
	{
		$plan = CuentaPlanes::where('etiqueta', $request['pricing-plan'])->first();

		if (!$plan) {
			return 'error';
		}

		$paymentController = app()->make(\App\Http\Controllers\PaymentsController::class);
		$response = $paymentController->generatelink(new Request(['stripe_price' => $plan->stripe_price]));

		return response()->json([
			'msg' => 'ok',
			'url' => $response
		], 200);
	}

	public function cuenta_obtener(Request $request)
	{
		$etiqueta = $request->input('etiqueta'); // Obtenemos la etiqueta del request

		if (!$etiqueta) {
			return response()->json(['msg' => 'Se requiere la etiqueta de la cuenta.', 'code' => 400], 400);
		}

		try {
			$cuenta = Cuenta::where('etiqueta', $etiqueta) // Buscamos por etiqueta
				->where('usuario', Auth::id()) // Aseguramos que la cuenta pertenece al usuario autenticado
				->first();

			if (!$cuenta) {
				return response()->json(['msg' => 'Cuenta no encontrada o no pertenece al usuario autenticado.', 'code' => 404], 404);
			}

			return response()->json(['msg' => 'Cuenta obtenida con éxito.', 'cuenta' => $cuenta, 'code' => 200], 200);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al obtener la cuenta.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function cuenta_actualizar(Request $request)
	{
		$etiqueta = $request->input('etiqueta'); // Obtenemos la etiqueta del request

		$mensajes = [
			'nueva_etiqueta.string' => 'La nueva etiqueta de la cuenta debe ser una cadena de texto.',
			'nueva_etiqueta.max' => 'La nueva etiqueta de la cuenta no debe superar los 100 caracteres.',
			'nueva_etiqueta.unique' => 'Ya existe otra cuenta con esta nueva etiqueta para tu usuario.',
			'numero_identificador.string' => 'El número identificador debe ser una cadena de texto.',
			'numero_identificador.max' => 'El número identificador no debe superar los 255 caracteres.',
			'estado.in' => 'El estado de la cuenta no es válido.',
			'saldo.numeric' => 'El saldo debe ser un valor numérico.',
			'saldo.min' => 'El saldo no puede ser negativo.',
		];

		try {
			if (!$etiqueta) {
				return response()->json(['msg' => 'Se requiere la etiqueta de la cuenta a actualizar.', 'code' => 400], 400);
			}

			$cuenta = Cuenta::where('etiqueta', $etiqueta) // Buscamos por etiqueta
				->where('usuario', Auth::id())
				->first();

			if (!$cuenta) {
				return response()->json(['msg' => 'Cuenta no encontrada o no pertenece al usuario autenticado.', 'code' => 404], 404);
			}

			$validacion = $request->validate([
				'nueva_etiqueta' => [ // Campo para la nueva etiqueta si se quiere cambiar
					'sometimes',
					'string',
					'max:100',
					// Ignora la etiqueta de la cuenta actual al verificar la unicidad
					Rule::unique('00_cuentas', 'etiqueta')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					})->ignore($cuenta->id), // Usamos el ID para ignorar el registro actual
				],
				'numero_identificador' => 'sometimes|nullable|string|max:255',
				'estado' => 'sometimes|in:activa,inactiva,bloqueada',
				'saldo' => 'sometimes|numeric|min:0', // Cuidado al permitir actualizar el saldo directamente
			], $mensajes);

			// Si se proporciona una nueva etiqueta, actualizamos la etiqueta
			if (isset($validacion['nueva_etiqueta'])) {
				$cuenta->etiqueta = $validacion['nueva_etiqueta'];
				unset($validacion['nueva_etiqueta']); // Eliminamos para que no se intente actualizar dos veces
			}

			$cuenta->update($validacion);

			return response()->json(['msg' => 'Cuenta actualizada con éxito.', 'cuenta' => $cuenta, 'code' => 200], 200);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación al actualizar la cuenta.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al actualizar la cuenta.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function cuenta_eliminar(Request $request)
	{
		$etiqueta = $request->input('etiqueta'); // Obtenemos la etiqueta del request

		try {
			if (!$etiqueta) {
				return response()->json(['msg' => 'Se requiere la etiqueta de la cuenta a eliminar.', 'code' => 400], 400);
			}

			$cuenta = Cuenta::where('etiqueta', $etiqueta) // Buscamos por etiqueta
				->where('usuario', Auth::id())
				->first();

			if (!$cuenta) {
				return response()->json(['msg' => 'Cuenta no encontrada o no pertenece al usuario autenticado.', 'code' => 404], 404);
			}

			$cuenta->delete();

			return response()->json(['msg' => 'Cuenta eliminada con éxito.', 'code' => 200], 200);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al eliminar la cuenta.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	/* ----- TARJETA ------ */

	public function tarjeta_crear(Request $request)
	{
		$mensajes = [
			'stripe_card_id.required' => 'El ID de la tarjeta de Stripe es obligatorio.',
			'stripe_card_id.string' => 'El ID de la tarjeta de Stripe debe ser una cadena de texto.',
			'stripe_card_id.max' => 'El ID de la tarjeta de Stripe no debe superar los 255 caracteres.',
			'stripe_card_id.unique' => 'Esta tarjeta de Stripe ya ha sido registrada.',
			'last4.required' => 'Los últimos 4 dígitos de la tarjeta son obligatorios.',
			'last4.digits' => 'Los últimos 4 dígitos deben ser exactamente 4 dígitos.',
			'brand.required' => 'La marca de la tarjeta es obligatoria.',
			'brand.string' => 'La marca de la tarjeta debe ser una cadena de texto.',
			'brand.max' => 'La marca de la tarjeta no debe superar los 50 caracteres.',
			'exp_month.required' => 'El mes de expiración es obligatorio.',
			'exp_month.digits' => 'El mes de expiración debe ser un número de 2 dígitos.',
			'exp_month.between' => 'El mes de expiración debe estar entre 1 y 12.',
			'exp_year.required' => 'El año de expiración es obligatorio.',
			'exp_year.digits' => 'El año de expiración debe ser un número de 4 dígitos.',
			'exp_year.after_or_equal' => 'El año de expiración no puede ser anterior al año actual.',
			'estado.in' => 'El estado de la tarjeta no es válido.',
			'cuenta_etiqueta.required' => 'La etiqueta de la cuenta asociada a la tarjeta es obligatoria.',
			'cuenta_etiqueta.exists' => 'La cuenta asociada no existe o no pertenece al usuario autenticado.',
		];

		try {
			$validacion = $request->validate([
				'stripe_card_id' => 'required|string|max:255|unique:00_tarjetas,stripe_card_id',
				'last4' => 'required|digits:4',
				'brand' => 'required|string|max:50',
				'exp_month' => 'required|digits:2|integer|between:1,12',
				'exp_year' => 'required|digits:4|integer|min:' . date('Y'),
				'estado' => 'sometimes|in:activa,inactiva,expirada,bloqueada',
				'cuenta_etiqueta' => [ // Usamos etiqueta para buscar la cuenta
					'required',
					'string',
					'max:100',
					Rule::exists('00_cuentas', 'etiqueta')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					}),
				],
			], $mensajes);

			// Encontrar la cuenta por etiqueta
			$cuenta = Cuenta::where('etiqueta', $validacion['cuenta_etiqueta'])
				->where('usuario', Auth::id())
				->first();

			if (!$cuenta) {
				return response()->json(['msg' => 'La cuenta asociada no fue encontrada o no pertenece al usuario.', 'code' => 404], 404);
			}

			// Generar una etiqueta única para la tarjeta
			do {
				$etiquetaGenerada = Str::random(10);
			} while (Tarjeta::where('etiqueta', $etiquetaGenerada)->where('usuario', Auth::id())->exists());

			$tarjeta = Tarjeta::create([
				'etiqueta' => $etiquetaGenerada,
				'stripe_card_id' => $validacion['stripe_card_id'],
				'last4' => $validacion['last4'],
				'brand' => $validacion['brand'],
				'exp_month' => $validacion['exp_month'],
				'exp_year' => $validacion['exp_year'],
				'estado' => $validacion['estado'] ?? 'activa',
				'usuario' => Auth::id(),
				'cuenta' => $cuenta->id, // Guardamos el ID numérico de la cuenta
			]);

			return response()->json([
				'msg' => 'Tarjeta creada con éxito.',
				'tarjeta' => $tarjeta,
				'code' => 201
			], 201);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación al crear la tarjeta.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al crear la tarjeta.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function tarjeta_obtener(Request $request)
	{
		$etiqueta = $request->input('etiqueta');

		if (!$etiqueta) {
			return response()->json(['msg' => 'Se requiere la etiqueta de la tarjeta.', 'code' => 400], 400);
		}

		try {
			$tarjeta = Tarjeta::where('etiqueta', $etiqueta)
				->where('usuario', Auth::id())
				->first();

			if (!$tarjeta) {
				return response()->json(['msg' => 'Tarjeta no encontrada o no pertenece al usuario autenticado.', 'code' => 404], 404);
			}

			return response()->json(['msg' => 'Tarjeta obtenida con éxito.', 'tarjeta' => $tarjeta, 'code' => 200], 200);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al obtener la tarjeta.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function tarjeta_actualizar(Request $request)
	{
		$etiqueta = $request->input('etiqueta');

		$mensajes = [
			'nueva_etiqueta.string' => 'La nueva etiqueta de la tarjeta debe ser una cadena de texto.',
			'nueva_etiqueta.max' => 'La nueva etiqueta de la tarjeta no debe superar los 100 caracteres.',
			'nueva_etiqueta.unique' => 'Ya existe otra tarjeta con esta nueva etiqueta para tu usuario.',
			'estado.in' => 'El estado de la tarjeta no es válido.',
			'cuenta_etiqueta.exists' => 'La cuenta asociada no existe o no pertenece al usuario autenticado.',
		];

		try {
			if (!$etiqueta) {
				return response()->json(['msg' => 'Se requiere la etiqueta de la tarjeta a actualizar.', 'code' => 400], 400);
			}

			$tarjeta = Tarjeta::where('etiqueta', $etiqueta)
				->where('usuario', Auth::id())
				->first();

			if (!$tarjeta) {
				return response()->json(['msg' => 'Tarjeta no encontrada o no pertenece al usuario autenticado.', 'code' => 404], 404);
			}

			$validacion = $request->validate([
				'nueva_etiqueta' => [
					'sometimes',
					'string',
					'max:100',
					Rule::unique('00_tarjetas', 'etiqueta')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					})->ignore($tarjeta->id),
				],
				'estado' => 'sometimes|in:activa,inactiva,expirada,bloqueada',
				'cuenta_etiqueta' => [ // Usamos etiqueta para buscar la cuenta
					'sometimes',
					'string',
					'max:100',
					Rule::exists('00_cuentas', 'etiqueta')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					}),
				],
			], $mensajes);

			// Si se proporciona una nueva etiqueta, actualizamos la etiqueta
			if (isset($validacion['nueva_etiqueta'])) {
				$tarjeta->etiqueta = $validacion['nueva_etiqueta'];
				unset($validacion['nueva_etiqueta']);
			}

			// Si se proporciona una nueva cuenta asociada por etiqueta
			if (isset($validacion['cuenta_etiqueta'])) {
				$nuevaCuenta = Cuenta::where('etiqueta', $validacion['cuenta_etiqueta'])
					->where('usuario', Auth::id())
					->first();
				if ($nuevaCuenta) {
					$tarjeta->cuenta = $nuevaCuenta->id;
				} else {
					return response()->json(['msg' => 'La nueva cuenta asociada no fue encontrada o no pertenece al usuario.', 'code' => 404], 404);
				}
				unset($validacion['cuenta_etiqueta']);
			}

			$tarjeta->update($validacion);

			return response()->json(['msg' => 'Tarjeta actualizada con éxito.', 'tarjeta' => $tarjeta, 'code' => 200], 200);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación al actualizar la tarjeta.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al actualizar la tarjeta.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function tarjeta_eliminar(Request $request)
	{
		$etiqueta = $request->input('etiqueta');

		try {
			if (!$etiqueta) {
				return response()->json(['msg' => 'Se requiere la etiqueta de la tarjeta a eliminar.', 'code' => 400], 400);
			}

			$tarjeta = Tarjeta::where('etiqueta', $etiqueta)
				->where('usuario', Auth::id())
				->first();

			if (!$tarjeta) {
				return response()->json(['msg' => 'Tarjeta no encontrada o no pertenece al usuario autenticado.', 'code' => 404], 404);
			}

			$tarjeta->delete();

			return response()->json(['msg' => 'Tarjeta eliminada con éxito.', 'code' => 200], 200);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al eliminar la tarjeta.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	/* ----- STAKE ------ */

	public function stake_crear(Request $request)
	{
		$mensajes = [
			'etiqueta.required' => 'La etiqueta del stake es obligatoria.',
			'etiqueta.string' => 'La etiqueta del stake debe ser una cadena de texto.',
			'etiqueta.max' => 'La etiqueta del stake no debe superar los 100 caracteres.',
			'etiqueta.unique' => 'Ya existe un stake con esta etiqueta.',
			'nombre.required' => 'El nombre del stake es obligatorio.',
			'nombre.string' => 'El nombre del stake debe ser una cadena de texto.',
			'nombre.max' => 'El nombre del stake no debe superar los 100 caracteres.',
			'rendimiento.required' => 'El rendimiento es obligatorio.',
			'rendimiento.numeric' => 'El rendimiento debe ser un valor numérico.',
			'rendimiento.min' => 'El rendimiento no puede ser negativo.',
			'minimo.required' => 'El monto mínimo es obligatorio.',
			'minimo.numeric' => 'El monto mínimo debe ser un valor numérico.',
			'minimo.min' => 'El monto mínimo no puede ser negativo.',
			'moneda.required' => 'La moneda es obligatoria.',
			'moneda.string' => 'La moneda debe ser una cadena de texto.',
			'moneda.max' => 'La moneda no debe superar los 10 caracteres.',
			'icono.string' => 'El icono debe ser una cadena de texto.',
			'icono.max' => 'La ruta del icono no debe superar los 255 caracteres.',
			'estado.in' => 'El estado del stake no es válido.',
		];

		try {
			// Aquí la etiqueta es proporcionada por el usuario (administrador en este caso)
			$validacion = $request->validate([
				'nombre' => 'required|string|max:100',
				'rendimiento' => 'required|numeric|min:0',
				'minimo' => 'required|numeric|min:0',
				'moneda' => 'required|string|max:10',
				'icono' => 'sometimes|nullable|string|max:255',
				'estado' => 'sometimes|in:activo,inactivo,completo',
			], $mensajes);

			$stake = Stake::create([
				'etiqueta' => Str::random(10),
				'nombre' => $validacion['nombre'],
				'rendimiento' => $validacion['rendimiento'],
				'minimo' => $validacion['minimo'],
				'moneda' => $validacion['moneda'],
				'icono' => $validacion['icono'] ?? null,
				'estado' => $validacion['estado'] ?? 'activo',
			]);

			return response()->json([
				'msg' => 'Stake creado con éxito.',
				'stake' => $stake,
				'code' => 201
			], 201);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación al crear el stake.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al crear el stake.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function stake_obtener(Request $request)
	{
		$etiqueta = $request->etiqueta;

		if (!$etiqueta) {
			return response()->json(['msg' => 'Se requiere la etiqueta del stake.', 'code' => 400], 400);
		}

		try {
			$stake = Stake::where('etiqueta', $etiqueta)->first();

			if (!$stake) {
				return response()->json(['msg' => 'Stake no encontrado.', 'code' => 404], 404);
			}

			return response()->json(['msg' => 'Stake obtenido con éxito.', 'stake' => $stake, 'code' => 200], 200);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al obtener el stake.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function stake_actualizar(Request $request)
	{
		$etiqueta = $request->input('etiqueta');

		$mensajes = [
			'nueva_etiqueta.string' => 'La nueva etiqueta del stake debe ser una cadena de texto.',
			'nueva_etiqueta.max' => 'La nueva etiqueta del stake no debe superar los 100 caracteres.',
			'nueva_etiqueta.unique' => 'Ya existe otro stake con esta nueva etiqueta.',
			'nombre.string' => 'El nombre del stake debe ser una cadena de texto.',
			'nombre.max' => 'El nombre del stake no debe superar los 100 caracteres.',
			'rendimiento.numeric' => 'El rendimiento debe ser un valor numérico.',
			'rendimiento.min' => 'El rendimiento no puede ser negativo.',
			'minimo.numeric' => 'El monto mínimo debe ser un valor numérico.',
			'minimo.min' => 'El monto mínimo no puede ser negativo.',
			'moneda.string' => 'La moneda debe ser una cadena de texto.',
			'moneda.max' => 'La moneda no debe superar los 10 caracteres.',
			'icono.string' => 'El icono debe ser una cadena de texto.',
			'icono.max' => 'La ruta del icono no debe superar los 255 caracteres.',
			'estado.in' => 'El estado del stake no es válido.',
		];

		try {
			if (!$etiqueta) {
				return response()->json(['msg' => 'Se requiere la etiqueta del stake a actualizar.', 'code' => 400], 400);
			}

			$stake = Stake::where('etiqueta', $etiqueta)->first();

			if (!$stake) {
				return response()->json(['msg' => 'Stake no encontrado.', 'code' => 404], 404);
			}

			$validacion = $request->validate([
				'nueva_etiqueta' => 'sometimes|string|max:100|unique:00_stakes,etiqueta,' . $stake->id, // Ignora el ID del stake actual
				'nombre' => 'sometimes|string|max:100',
				'rendimiento' => 'sometimes|numeric|min:0',
				'minimo' => 'sometimes|numeric|min:0',
				'moneda' => 'sometimes|string|max:10',
				'icono' => 'sometimes|nullable|string|max:255',
				'estado' => 'sometimes|in:activo,inactivo,completo',
			], $mensajes);

			if (isset($validacion['nueva_etiqueta'])) {
				$stake->etiqueta = $validacion['nueva_etiqueta'];
				unset($validacion['nueva_etiqueta']);
			}

			$stake->update($validacion);

			return response()->json(['msg' => 'Stake actualizado con éxito.', 'stake' => $stake, 'code' => 200], 200);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación al actualizar el stake.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al actualizar el stake.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function stake_eliminar(Request $request)
	{
		$etiqueta = $request->input('etiqueta');

		try {
			if (!$etiqueta) {
				return response()->json(['msg' => 'Se requiere la etiqueta del stake a eliminar.', 'code' => 400], 400);
			}

			$stake = Stake::where('etiqueta', $etiqueta)->first();

			if (!$stake) {
				return response()->json(['msg' => 'Stake no encontrado.', 'code' => 404], 404);
			}

			$stake->delete();

			return response()->json(['msg' => 'Stake eliminado con éxito.', 'code' => 200], 200);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al eliminar el stake.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	/* ----- USUARIO STAKE ------ */

	public function u_stake_crear(Request $request)
	{
		$mensajes = [
			'monto_invertido.required' => 'El monto invertido es obligatorio.',
			'monto_invertido.numeric' => 'El monto invertido debe ser un valor numérico.',
			'monto_invertido.min' => 'El monto invertido no puede ser negativo.',
			'estado.in' => 'El estado del stake de usuario no es válido.',
			'cuenta_etiqueta.required' => 'La etiqueta de la cuenta para el stake es obligatoria.',
			'cuenta_etiqueta.exists' => 'La cuenta especificada no existe o no pertenece al usuario autenticado.',
			'stake_etiqueta.required' => 'La etiqueta del tipo de stake es obligatoria.',
			'stake_etiqueta.exists' => 'El tipo de stake especificado no existe.',
		];

		try {
			$validacion = $request->validate([
				'monto_invertido' => 'required|numeric|min:0',
				'estado' => 'sometimes|in:activo,finalizado,cancelado,pendiente',
				'cuenta_etiqueta' => [ // Usamos etiqueta para buscar la cuenta
					'required',
					'string',
					'max:100',
					Rule::exists('00_cuentas', 'etiqueta')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					}),
				],
				'stake_etiqueta' => 'required|exists:00_stakes,etiqueta', // Usamos etiqueta para buscar el stake
			], $mensajes);

			// Encontrar la cuenta y el tipo de stake por etiqueta
			$cuenta = Cuenta::where('etiqueta', $validacion['cuenta_etiqueta'])
				->where('usuario', Auth::id())
				->first();

			$stakeType = Stake::where('etiqueta', $validacion['stake_etiqueta'])->first();

			if (!$cuenta) {
				return response()->json(['msg' => 'La cuenta especificada no fue encontrada o no pertenece al usuario.', 'code' => 404], 404);
			}
			if (!$stakeType) {
				return response()->json(['msg' => 'El tipo de stake especificado no fue encontrado.', 'code' => 404], 404);
			}

			// Validar monto mínimo del stake
			if ($validacion['monto_invertido'] < $stakeType->minimo) {
				return response()->json(['msg' => 'El monto invertido es menor al mínimo requerido para este stake (' . number_format($stakeType->minimo, 2, ',', '.') . ').', 'code' => 400], 400);
			}

			// Lógica para verificar el saldo de la cuenta antes de crear el stake
			if ($cuenta->saldo < $validacion['monto_invertido']) {
				return response()->json(['msg' => 'Saldo insuficiente en la cuenta para realizar el stake.', 'code' => 400], 400);
			}

			// Restar el monto de la cuenta
			$val = [
				'cuenta_origen' => $cuenta->etiqueta,
				'monto' => $validacion['monto_invertido'],
				'tipo' => 'rendimiento_stake',
				'fetch' => 'stake',
			];

			// Realiza la transferencia
			$this->quicktransfer(new Request($val));

			// Generar una etiqueta única para el stake de usuario
			do {
				$etiquetaGenerada = Str::random(10);
			} while (StakeUsuario::where('etiqueta', $etiquetaGenerada)->where('usuario', Auth::id())->exists());

			$uStake = StakeUsuario::create([
				'etiqueta' => $etiquetaGenerada,
				'monto_invertido' => $validacion['monto_invertido'],
				'rendimiento_obtenido' => 0.00, // Inicializar en 0
				'fecha_inicio' => Carbon::now(),
				'fecha_final' => Carbon::now()->addYear(),
				'estado' => $validacion['estado'] ?? 'activo',
				'usuario' => Auth::id(),
				'cuenta' => $cuenta->id, // Guardamos el ID numérico de la cuenta
				'stake_id' => $stakeType->id, // Guardamos el ID numérico del tipo de stake
			]);

			return response()->json([
				'msg' => 'Stake de usuario creado con éxito.',
				'u_stake' => $uStake,
				'code' => 201
			], 201);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación al crear el stake de usuario.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al crear el stake de usuario.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function u_stake_obtener(Request $request)
	{
		$etiqueta = $request->input('etiqueta');

		if (!$etiqueta) {
			return response()->json(['msg' => 'Se requiere la etiqueta del stake de usuario.', 'code' => 400], 400);
		}

		try {
			$uStake = StakeUsuario::where('etiqueta', $etiqueta)
				->where('usuario', Auth::id())
				->with(['stakeType', 'cuenta'])
				->first();

			if (!$uStake) {
				return response()->json(['msg' => 'Stake de usuario no encontrado o no pertenece al usuario autenticado.', 'code' => 404], 404);
			}

			return response()->json(['msg' => 'Stake de usuario obtenido con éxito.', 'u_stake' => $uStake, 'code' => 200], 200);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al obtener el stake de usuario.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function u_stake_actualizar(Request $request)
	{
		$etiqueta = $request->input('etiqueta');

		$mensajes = [
			'nueva_etiqueta.string' => 'La nueva etiqueta del stake de usuario debe ser una cadena de texto.',
			'nueva_etiqueta.max' => 'La nueva etiqueta del stake de usuario no debe superar los 100 caracteres.',
			'nueva_etiqueta.unique' => 'Ya existe otro stake de usuario con esta nueva etiqueta para tu usuario.',
			'monto_invertido.numeric' => 'El monto invertido debe ser un valor numérico.',
			'monto_invertido.min' => 'El monto invertido no puede ser negativo.',
			'rendimiento_obtenido.numeric' => 'El rendimiento obtenido debe ser un valor numérico.',
			'rendimiento_obtenido.min' => 'El rendimiento obtenido no puede ser negativo.',
			'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
			'fecha_final.date' => 'La fecha final debe ser una fecha válida.',
			'fecha_final.after_or_equal' => 'La fecha final no puede ser anterior a la fecha de inicio.',
			'estado.in' => 'El estado del stake de usuario no es válido.',
			'cuenta_etiqueta.exists' => 'La cuenta especificada no existe o no pertenece al usuario autenticado.',
			'stake_etiqueta.exists' => 'El tipo de stake especificado no existe.',
		];

		try {
			if (!$etiqueta) {
				return response()->json(['msg' => 'Se requiere la etiqueta del stake de usuario a actualizar.', 'code' => 400], 400);
			}

			$uStake = StakeUsuario::where('etiqueta', $etiqueta)
				->where('usuario', Auth::id())
				->first();

			if (!$uStake) {
				return response()->json(['msg' => 'Stake de usuario no encontrado o no pertenece al usuario autenticado.', 'code' => 404], 404);
			}

			$validacion = $request->validate([
				'nueva_etiqueta' => [
					'sometimes',
					'string',
					'max:100',
					Rule::unique('00_stake_usuario', 'etiqueta')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					})->ignore($uStake->id),
				],
				'monto_invertido' => 'sometimes|numeric|min:0',
				'rendimiento_obtenido' => 'sometimes|numeric|min:0',
				'fecha_inicio' => 'sometimes|date',
				'fecha_final' => 'sometimes|nullable|date|after_or_equal:fecha_inicio',
				'estado' => 'sometimes|in:activo,finalizado,cancelado,pendiente',
				'cuenta_etiqueta' => [ // Usamos etiqueta para buscar la cuenta
					'sometimes',
					'string',
					'max:100',
					Rule::exists('00_cuentas', 'etiqueta')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					}),
				],
				'stake_etiqueta' => 'sometimes|exists:00_stakes,etiqueta', // Usamos etiqueta para buscar el stake
			], $mensajes);

			// Si se proporciona una nueva etiqueta, actualizamos la etiqueta
			if (isset($validacion['nueva_etiqueta'])) {
				$uStake->etiqueta = $validacion['nueva_etiqueta'];
				unset($validacion['nueva_etiqueta']);
			}

			// Si se proporciona una nueva cuenta asociada por etiqueta
			if (isset($validacion['cuenta_etiqueta'])) {
				$nuevaCuenta = Cuenta::where('etiqueta', $validacion['cuenta_etiqueta'])
					->where('usuario', Auth::id())
					->first();
				if ($nuevaCuenta) {
					$uStake->cuenta = $nuevaCuenta->id;
				} else {
					return response()->json(['msg' => 'La nueva cuenta asociada no fue encontrada o no pertenece al usuario.', 'code' => 404], 404);
				}
				unset($validacion['cuenta_etiqueta']);
			}

			// Si se proporciona un nuevo tipo de stake por etiqueta
			if (isset($validacion['stake_etiqueta'])) {
				$nuevoStakeType = Stake::where('etiqueta', $validacion['stake_etiqueta'])->first();
				if ($nuevoStakeType) {
					$uStake->stake_id = $nuevoStakeType->id;
				} else {
					return response()->json(['msg' => 'El nuevo tipo de stake no fue encontrado.', 'code' => 404], 404);
				}
				unset($validacion['stake_etiqueta']);
			}

			$uStake->update($validacion);

			return response()->json(['msg' => 'Stake de usuario actualizado con éxito.', 'u_stake' => $uStake, 'code' => 200], 200);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación al actualizar el stake de usuario.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al actualizar el stake de usuario.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function u_stake_eliminar(Request $request)
	{
		$etiqueta = $request->input('etiqueta');

		try {
			if (!$etiqueta) {
				return response()->json(['msg' => 'Se requiere la etiqueta del stake de usuario a eliminar.', 'code' => 400], 400);
			}

			$uStake = StakeUsuario::where('etiqueta', $etiqueta)
				->where('usuario', Auth::id())
				->first();

			if (!$uStake) {
				return response()->json(['msg' => 'Stake de usuario no encontrado o no pertenece al usuario autenticado.', 'code' => 404], 404);
			}

			// Antes de eliminar, considera revertir el monto invertido si la lógica de negocio lo requiere.
			// Por ejemplo, si el stake es cancelado, el monto_invertido podría volver a la cuenta del usuario.
			// $cuenta = Cuenta::find($uStake->cuenta);
			// if ($cuenta) {
			//     $cuenta->increment('saldo', $uStake->monto_invertido);
			//     $cuenta->save();
			// }

			$uStake->delete();

			return response()->json(['msg' => 'Stake de usuario eliminado con éxito.', 'code' => 200], 200);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al eliminar el stake de usuario.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	/* ----- TRANSACCION ------ */

	public function transaccion_crear(Request $request)
	{
		$mensajes = [
			'etiqueta_desc.string' => 'La etiqueta o descripción de la transacción debe ser una cadena de texto.',
			'etiqueta_desc.max' => 'La etiqueta o descripción de la transacción no debe superar los 100 caracteres.',
			'fecha.required' => 'La fecha de la transacción es obligatoria.',
			'fecha.date' => 'La fecha de la transacción debe ser una fecha válida.',
			'tipo.required' => 'El tipo de transacción es obligatorio.',
			'tipo.in' => 'El tipo de transacción no es válido.',
			'monto.required' => 'El monto de la transacción es obligatorio.',
			'monto.numeric' => 'El monto de la transacción debe ser un valor numérico.',
			'monto.min' => 'El monto de la transacción no puede ser negativo.',
			'cuenta_saliente_etiqueta.exists' => 'La cuenta saliente no existe o no pertenece al usuario autenticado.',
			'cuenta_entrante_etiqueta.exists' => 'La cuenta entrante no existe o no pertenece al usuario autenticado.',
			'tarjeta_etiqueta.exists' => 'La tarjeta no existe o no pertenece al usuario autenticado.',
			'monto.gt' => 'El monto de la transacción debe ser mayor que cero.',
		];

		try {
			$validacion = $request->validate([
				'etiqueta_desc' => 'sometimes|nullable|string|max:100', // Campo opcional para descripción
				'fecha' => 'required|date',
				'tipo' => 'required|in:deposito,retiro,transferencia_interna,pago,reembolso,comision,rendimiento_stake',
				'monto' => 'required|numeric|min:0.01',
				'cuenta_saliente' => [
					'required',
					'string',
					'max:100',
					Rule::exists('00_cuentas', 'etiqueta')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					}),
				],
				'cuenta_entrante' => [
					'nullable',
					'string',
					'max:100',
					Rule::exists('00_cuentas', 'etiqueta')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					}),
				],
				'tarjeta_etiqueta' => [
					'nullable',
					'string',
					'max:100',
					Rule::exists('00_tarjetas', 'etiqueta')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					}),
				],
				'estado' => 'sometimes|in:completada,pendiente,fallida,revertida',
			], $mensajes);

			// Buscar IDs numéricos basados en las etiquetas
			$cuentaSaliente = null;
			if (isset($validacion['cuenta_saliente'])) {
				$cuentaSaliente = Cuenta::where('etiqueta', $validacion['cuenta_saliente'])
					->where('usuario', Auth::id())
					->first();
				if (!$cuentaSaliente) {
					return response()->json(['msg' => 'La cuenta saliente no fue encontrada o no pertenece al usuario.', 'code' => 404], 404);
				}
			}

			$cuentaEntrante = null;
			if (isset($validacion['cuenta_entrante'])) {
				$cuentaEntrante = Cuenta::where('etiqueta', $validacion['cuenta_entrante'])
					->where('usuario', Auth::id())
					->first();
				if (!$cuentaEntrante) {
					return response()->json(['msg' => 'La cuenta entrante no fue encontrada o no pertenece al usuario.', 'code' => 404], 404);
				}
			}

			$tarjeta = null;
			if (isset($validacion['tarjeta_etiqueta'])) {
				$tarjeta = Tarjeta::where('etiqueta', $validacion['tarjeta_etiqueta'])
					->where('usuario', Auth::id())
					->first();
				if (!$tarjeta) {
					return response()->json(['msg' => 'La tarjeta no fue encontrada o no pertenece al usuario.', 'code' => 404], 404);
				}
			}

			// Lógica para manejar la transferencia de fondos (ejemplo básico)
			// Esto es crucial y debe ser muy robusto en un entorno de producción
			// Aquí solo se muestra un ejemplo básico de cómo podrías interactuar con los saldos
			if ($validacion['tipo'] === 'retiro' || $validacion['tipo'] === 'transferencia_interna' || $validacion['tipo'] === 'pago') {
				if (!$cuentaSaliente) {
					return response()->json(['msg' => 'Se requiere una cuenta saliente para este tipo de transacción.', 'code' => 400], 400);
				}
				if ($cuentaSaliente->saldo < $validacion['monto']) {
					return response()->json(['msg' => 'Saldo insuficiente en la cuenta saliente.', 'code' => 400], 400);
				}
				$cuentaSaliente->decrement('saldo', $validacion['monto']);
			}

			if ($validacion['tipo'] === 'deposito' || $validacion['tipo'] === 'transferencia_interna' || $validacion['tipo'] === 'reembolso' || $validacion['tipo'] === 'rendimiento_stake') {
				if (!$cuentaEntrante) {
					return response()->json(['msg' => 'Se requiere una cuenta entrante para este tipo de transacción.', 'code' => 400], 400);
				}
				$cuentaEntrante->increment('saldo', $validacion['monto']);
			}

			// Generar una etiqueta única para la transacción
			do {
				$etiquetaGenerada = Str::random(10);
			} while (TransaccionUsuario::where('etiqueta', $etiquetaGenerada)->where('usuario', Auth::id())->exists());

			$transaccion = TransaccionUsuario::create([
				'etiqueta' => $etiquetaGenerada, // Usamos la etiqueta generada
				'fecha' => $validacion['fecha'],
				'tipo' => $validacion['tipo'],
				'monto' => $validacion['monto'],
				'cuenta_saliente' => $cuentaSaliente ? $cuentaSaliente->id : null,
				'cuenta_entrante' => $cuentaEntrante ? $cuentaEntrante->id : null,
				'tarjeta_id' => $tarjeta ? $tarjeta->id : null,
				'estado' => $validacion['estado'] ?? 'pendiente',
				'usuario' => Auth::id(),
			]);

			return response()->json([
				'msg' => 'Transacción creada con éxito.',
				'transaccion' => $transaccion,
				'code' => 201
			], 201);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación al crear la transacción.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al crear la transacción.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	public function transaccion_obtener(Request $request)
	{
		$etiqueta = $request->input('etiqueta');

		if (!$etiqueta) {
			return response()->json(['msg' => 'Se requiere la etiqueta de la transacción.', 'code' => 400], 400);
		}

		try {
			$transaccion = TransaccionUsuario::where('etiqueta', $etiqueta)
				->where('usuario', Auth::id())
				->with(['cuentaSaliente', 'cuentaEntrante', 'tarjeta'])
				->first();

			if (!$transaccion) {
				return response()->json(['msg' => 'Transacción no encontrada o no pertenece al usuario autenticado.', 'code' => 404], 404);
			}

			return response()->json(['msg' => 'Transacción obtenida con éxito.', 'transaccion' => $transaccion, 'code' => 200], 200);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al obtener la transacción.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	/* ----- KYC ------ */
	public function kyc_crear(Request $request)
	{
		$mensajes = [
			'nombre_completo.required' => 'El nombre completo es obligatorio.',
			'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
			'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
			'tipo_documento.required' => 'El tipo de documento es obligatorio.',
			'numero_documento.required' => 'El número de documento es obligatorio.',
			'pais_emision.required' => 'El país de emisión es obligatorio.',
			'direccion.required' => 'La dirección es obligatoria.',
			'codigo_postal.required' => 'El código postal es obligatorio.',
			'ciudad.required' => 'La ciudad es obligatoria.',
			'provincia.required' => 'La provincia es obligatoria.',
			'pais_residencia.required' => 'El país de residencia es obligatorio.',
			'telefono.required' => 'El teléfono es obligatorio.',
			'correo_electronico.required' => 'El correo electrónico es obligatorio.',
			'correo_electronico.email' => 'El correo electrónico debe ser una dirección válida.',
			'fuente_fondos.required' => 'La fuente de fondos es obligatoria.',
			'documento_frontal.required' => 'El documento frontal es obligatorio.',
			'documento_frontal.image' => 'El documento frontal debe ser una imagen.',
			'documento_trasero.required' => 'El documento trasero es obligatorio.',
			'documento_trasero.image' => 'El documento trasero debe ser una imagen.',
			'selfie_documento.required' => 'La selfie con el documento es obligatoria.',
			'selfie_documento.image' => 'La selfie con el documento debe ser una imagen.',
		];

		try {
			$validacion = $request->validate([
				'nombre_completo' => 'required|string|max:255',
				'fecha_nacimiento' => 'required|date',
				'tipo_documento' => 'required|string|max:50',
				'numero_documento' => 'required|string|max:50',
				'pais_emision' => 'required|string|max:50',
				'direccion' => 'required|string|max:255',
				'codigo_postal' => 'required|string|max:20',
				'ciudad' => 'required|string|max:100',
				'provincia' => 'required|string|max:100',
				'pais_residencia' => 'required|string|max:50',
				'telefono' => 'required|string|max:20',
				'correo_electronico' => 'required|email|max:100',
				'fuente_fondos' => 'required|string|max:255',
				'documento_frontal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50000',
				'documento_trasero' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50000',
				'selfie_documento' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50000',
			], $mensajes);

			// Procesamiento de imágenes
			$documentoFrontalPath = $request->file('documento_frontal')->store('kyc', 'public');
			$documentoTraseroPath = $request->file('documento_trasero')->store('kyc', 'public');
			$selfieDocumentoPath = $request->file('selfie_documento')->store('kyc', 'public');

			// Creación de la etiqueta
			$etiqueta = Str::uuid();

			// Creación del registro KYC
			$kyc = TablaKyc::create([
				'etiqueta' => $etiqueta,
				'nombre_completo' => $validacion['nombre_completo'],
				'fecha_nacimiento' => $validacion['fecha_nacimiento'],
				'tipo_documento' => $validacion['tipo_documento'],
				'numero_documento' => $validacion['numero_documento'],
				'pais_emision' => $validacion['pais_emision'],
				'direccion' => $validacion['direccion'],
				'codigo_postal' => $validacion['codigo_postal'],
				'ciudad' => $validacion['ciudad'],
				'provincia' => $validacion['provincia'],
				'pais_residencia' => $validacion['pais_residencia'],
				'telefono' => $validacion['telefono'],
				'correo_electronico' => $validacion['correo_electronico'],
				'fuente_fondos' => $validacion['fuente_fondos'],
				'documento_frontal' => '/storage/' . $documentoFrontalPath,
				'documento_trasero' => '/storage/' . $documentoTraseroPath,
				'selfie_documento' => '/storage/' . $selfieDocumentoPath,
				'estado' => 'pendiente',
				'usuario' => Auth::id(),
			]);

			return response()->json([
				'msg' => 'KYC creado con éxito.',
				'kyc' => $kyc,
				'code' => 201
			], 201);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación al crear el KYC.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado al crear el KYC.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}
	}

	/* ----- AÑADIR FONDOS ------ */
	public function añadir_fondos(Request $request)
	{

		$mensajes = [
			'cuenta.required' => 'La cuenta es obligatoria.',
			'cuenta.exists' => 'La cuenta no existe o no es válida.',
			'monto.required' => 'El monto es obligatorio.',
			'monto.numeric' => 'El monto debe ser un valor numérico.',
			'monto.min' => 'El monto debe ser al menos 10.',
			'monto.max' => 'El monto no puede exceder los 100,000€.',
		];

		$validacion = $request->validate([
			'cuenta' => 'required|exists:00_cuentas,numero_identificador',
			'monto' => 'required|numeric|min:10|max:100000'
		], $mensajes);

		// Contacta con Stripe para crear una sesión nueva dinámica
		$paymentController = app()->make(\App\Http\Controllers\PaymentsController::class);
		$response = $paymentController->stripe_link_dinamico(new Request([
			'monto' => $validacion['monto'],
			'func' => 'f2',
			'cuenta' => $validacion['cuenta'],
		]));

		return response()->json([
			'msg' => 'Enlace de pago generado con éxito.',
			'url' => $response,
			'code' => 200
		], 200);
	}

	/* ----- SYSTEM ------ */
	public function transferencia(Request $request)
	{
		$mensaje = [
			'cuenta_origen.required' => 'La cuenta de origen es obligatoria.',
			'cuenta_origen.exists' => 'La cuenta de origen no existe o no pertenece al usuario autenticado.',
			'cuenta_destino.required' => 'La cuenta de destino es obligatoria.',
			'cuenta_destino.exists' => 'La cuenta de destino no existe o no pertenece al usuario autenticado.',
			'monto.required' => 'El monto a transferir es obligatorio.',
			'monto.numeric' => 'El monto a transferir debe ser un valor numérico.',
			'monto.min' => 'El monto a transferir no puede ser negativo.',
			'monto.gt' => 'El monto a transferir debe ser mayor que cero.',
			'usuario.required' => 'El usuario es obligatorio.',
			'usuario.exists' => 'El usuario no existe.',
		];

		try {
			$validacion = $request->validate([
				'cuenta_origen' => [
					'required',
					'max:100',
					Rule::exists('00_cuentas', 'numero_identificador')->where(function ($query) {
						return $query->where('usuario', Auth::id());
					}),
				],
				'cuenta_destino' => [
					'required',
					'string',
					'max:100',
				],
				'usuario' => [
					'required',
					'string',
					'max:10',
					'exists:00_usuarios,etiqueta',
				],
				'monto' => 'required|numeric|min:0.01',
			], $mensaje);

			// Buscar el usuario autenticado
			$usuario = Usuarios::where('etiqueta', $validacion['usuario'])->first();

			// Buscar las cuentas por etiqueta
			$cuentaOrigen = Cuenta::where('numero_identificador', $validacion['cuenta_origen'])
				->where('usuario', Auth::id())
				->first();
			$cuentaDestino = Cuenta::where('numero_identificador', $validacion['cuenta_destino'])
				->where('usuario', $usuario->id)
				->first();
			if (!$cuentaOrigen) {
				return response()->json(['msg' => 'La cuenta de origen no fue encontrada o no pertenece al usuario.', 'code' => 404], 404);
			}
			if (!$cuentaDestino) {
				return response()->json(['msg' => 'La cuenta de destino no fue encontrada o no pertenece al usuario.', 'code' => 404], 404);
			}
			// Verificar si la cuenta de origen tiene suficiente saldo
			if ($cuentaOrigen->saldo < $validacion['monto']) {
				return response()->json(['msg' => 'Saldo insuficiente en la cuenta de origen.', 'code' => 400], 400);
			}
			// Realizar la transferencia
			$cuentaOrigen->decrement('saldo', $validacion['monto']);
			$cuentaDestino->increment('saldo', $validacion['monto']);
			// Crear la transacción de transferencia
			$transaccion = TransaccionUsuario::create([
				'etiqueta' => Str::random(10),
				'fecha' => now(),
				'tipo' => 'transferencia_interna',
				'monto' => $validacion['monto'],
				'cuenta_saliente' => $cuentaOrigen->id,
				'cuenta_entrante' => $cuentaDestino->id,
				'estado' => 'completada',
				'usuario' => Auth::id(),
			]);
			// Crear la transacción de ingreso en la cuenta de origen
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}

		return response()->json(['message' => 'Transferencia realizada con éxito']);
	}

	public function quicktransfer(Request $request)
	{
		$mensaje = [
			'monto.required' => 'El monto a transferir es obligatorio.',
			'monto.numeric' => 'El monto a transferir debe ser un valor numérico.',
			'monto.min' => 'El monto a transferir no puede ser negativo.',
			'monto.gt' => 'El monto a transferir debe ser mayor que cero.',
		];

		$cuenta_destino = '';

		switch ($request->fetch) {
			case 'stake':
				$cuenta_destino = '3wd89j0d-2d2t-sf34-e23s-89Ijk92kla9d';
				break;

			case 'general':
				$cuenta_destino = '37dsaj38-38aj-3298-auy8-aec98ah2ld92';
				break;

			case 'tesoreria':
				$cuenta_destino = 'q389duj3-ad8k-39dk-0q2d-0389ujad89ad';
				break;

			default:
				// Cuenta general
				$cuenta_destino = '37dsaj38-38aj-3298-auy8-aec98ah2ld92';
				break;
		}

		try {
			$validacion = $request->validate([
				'cuenta_origen' => [
					'required',
					'string',
					'max:100',
					'exists:00_cuentas,etiqueta',
				],
				'monto' => 'required|numeric|min:0.01',
			], $mensaje);

			// Buscar las cuentas por etiqueta
			$cuentaOrigen = Cuenta::where('etiqueta', $validacion['cuenta_origen'])->first();
			$cuentaDestino = Cuenta::where('etiqueta', $cuenta_destino)->first();

			if (!$cuentaOrigen) {
				return response()->json(['msg' => 'La cuenta de origen no fue encontrada.', 'code' => 404], 404);
			}
			if (!$cuentaDestino) {
				return response()->json(['msg' => 'La cuenta de destino no fue encontrada.', 'code' => 404], 404);
			}

			// Verificar si la cuenta de origen tiene suficiente saldo
			if ($cuentaOrigen->saldo < $validacion['monto']) {
				return response()->json(['msg' => 'Saldo insuficiente en la cuenta de origen.', 'code' => 400], 400);
			}

			// Realizar la transferencia
			$cuentaOrigen->decrement('saldo', $validacion['monto']);
			$cuentaDestino->increment('saldo', $validacion['monto']);

			///// TIPOS DE TRANSFERENCIAS //////////
			// deposito
			// retiro
			// transferencia_interna
			// pago
			// reembolso
			// comision
			// rendimiento_stake

			// Crear la transacción de transferencia
			$transaccion = TransaccionUsuario::create([
				'etiqueta' => Str::random(10),
				'fecha' => now(),
				'tipo' => $request['tipo'] ?? 'transferencia_interna',
				'monto' => $validacion['monto'],
				'cuenta_saliente' => $cuentaOrigen->id,
				'cuenta_entrante' => $cuentaDestino->id,
				'estado' => 'completada',
				'usuario' => Auth::id(),
			]);
		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json(['errors' => $e->validator->errors()->getMessages(), 'msg' => 'Error de validación.', 'code' => 422], 422);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'Ha ocurrido un error inesperado.', 'error' => $e->getMessage(), 'code' => 500], 500);
		}

		return response()->json(['message' => 'Transferencia realizada con éxito']);
	}
}
