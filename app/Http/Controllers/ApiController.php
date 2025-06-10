<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordToken;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Cookie;


class ApiController extends Controller
{
	// --------------------------------	//
	//					  AUTH					//
	// --------------------------------	//

	# Registrarse
	public function api_registro(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nombre' => 'required|string|max:50',
			'apellido_1' => 'required|string|max:50',
			'apellido_2' => 'required|string|max:50',
			'nombre_usuario' => 'required|string|max:20|unique:00_usuarios,nombre_usuario',
			'correo' => 'required|string|email|max:255|unique:00_usuarios,correo',
			'password' => 'required|string|min:8',
		]);

		if ($validator->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validator->errors()
			], 422);
		}

		// Si pasa la validación:
		$datos = $validator->validated();

		$usuario = Usuarios::create([
			'uuid' => Str::uuid(),
			'etiqueta' => Str::random(7),
			'nombre' => $datos['nombre'],
			'apellido_1' => $datos['apellido_1'],
			'apellido_2' => $datos['apellido_2'],
			'nombre_usuario' => $datos['nombre_usuario'],
			'correo' => $datos['correo'],
			'password' => Hash::make($datos['password']),
		]);

		return response()->json([
			'mensaje' => 'Usaurio creado con éxito',
			'datos' => $usuario
		]);
	}

	# Iniciar sesión POSTMAN
	public function api_login_postman(Request $request)
	{
		$credenciales = $request->validate([
			'correo' => 'required|string|email',
			'password' => 'required|string',
		]);

		if (!$token = auth('api')->attempt($credenciales)) {
			return response()->json([
				'mensaje' => 'Credenciales incorrectas'
			], 401);
		}

		$usuario = auth('api')->user();

		return response()->json([
			'mensaje' => 'Inicio de sesión exitoso',
			'usuario' => $usuario,
			'token' => $token
		]);
	}

	# Iniciar sesión
	public function api_login(Request $request)
	{

		$credenciales = $request->validate([
			'correo' => 'required|string|email',
			'password' => 'required|string',
		]);

		if (!$token = auth('api')->attempt($credenciales)) {
			return response()->json([
				'mensaje' => 'Credenciales incorrectas'
			], 401);
		}

		$usuario = auth('api')->user();
		$token = JWTAuth::fromUser($usuario);

		// Crea una cookie segura con SameSite=Lax (funciona en AJAX mismo dominio)
		$cookie = cookie(
			'jwt_token',                         // Nombre
			$token,                              // Valor
			config('session.lifetime'),          // Duración (en minutos, desde session.php)
			config('session.path'),              // Path
			config('session.domain'),            // Dominio (null o .dominio.com)
			config('session.secure'),            // Secure (true en producción)
			true,                                // HttpOnly
			false,                               // Raw
			config('session.same_site', 'lax')   // SameSite (lax por defecto)
		);

		return response()->json([
			'mensaje' => 'Inicio de sesión con sesión exitoso',
			'usuario' => $usuario,
			'token' => $token,
		])->cookie($cookie);

		return response()->json([
			'mensaje' => 'Credenciales incorrectas'
		], 401);
	}

	# Cerrar sesión
	public function logout(Request $request)
	{
		// Cierra la sesión normal
		auth('web')->logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();

		// Invalidar token JWT si viene en el header Authorization
		try {
			JWTAuth::parseToken()->invalidate();
		} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
			// Token no válido o no presente, puedes ignorar o registrar
		}

		return redirect('/login'); // o response JSON si es API
	}

	# Recuperación de contraseña
	public function recuperar(Request $request)
	{
		$credenciales = $request->validate([
			'nombre_usuario' => 'required|string|max:30',
			'correo' => 'required|string|max:30',
		]);

		# Fetch al usuario
		$usuario = Usuarios::where('nombre_usuario', $credenciales['nombre_usuario'])
			->where('correo', $credenciales['correo'])
			->first();

		if (!$usuario) {
			// No decir si es usuario o correo inválido por seguridad
			return response()->json([
				'mensaje' => 'Si los datos son correctos, recibirás un enlace de recuperación.',
			]);
		}

		# Crea el token
		$token = Str::uuid();

		# Guarda o actualiza el token
		DB::table('password_reset_tokens')->updateOrInsert(
			['email' => $usuario->correo],
			['token' => $token, 'created_at' => now()]
		);

		return response()->json([
			'mensaje' => 'Si los datos son correctos, recibirás un enlace de recuperación.',
		]);
	}

	# Cambiar contraseña
	public function cambiar_password(Request $request)
	{

		$datos = Validator::make($request->all(), [
			'token' => 'required|string',
			'password' => 'required|confirmed|string|min:8|max:20',
		]);

		if ($datos->fails()) {
			return response()->json([
				'mensaje' => 'Comprueba los campos',
				'errores' => $datos->errors()
			], 422);
		}

		// Buscar el registro del token
		$buscar = PasswordToken::where('token', $request['token'])->first();

		if (!$buscar) {
			return response()->json(['mensaje' => 'Token no válido.'], 400);
		}

		// Actualizar la contraseña del usuario asociado
		Usuarios::where('correo', $buscar['email'])->update([
			'password' => Hash::make($request['password'])
		]);

		// Eliminar el token para que no se reutilice
		$buscar->where('token', $request['token'])->delete();

		return response()->json([
			'mensaje' => 'Contraseña actualizada correctamente.'
		]);
	}
}
