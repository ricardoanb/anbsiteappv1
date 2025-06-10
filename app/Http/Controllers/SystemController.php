<?php

namespace App\Http\Controllers;

use App\Models\Stake;
use App\Rules\SerialValido;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoriasWeb;
use App\Models\PlanesUsuario;
use App\Models\CategoriasPanel;
use Illuminate\Support\Facades\Validator;

class SystemController extends Controller
{
	# Categorias WEB
	public function crear_categoria_web(Request $request)
	{
		$slugGenerado = strtolower(Str::slug($request->input('nombre')));

		$validator = Validator::make(array_merge($request->all(), ['slug' => $slugGenerado]), [
			'nombre' => 'required|string|max:50|unique:99_categorias_web',
			'slug' => 'unique:99_categorias_web,slug',
			'vault' => 'required|string|max:50|unique:99_categorias_web',
			'serial' => ['required', new SerialValido],
		]);

		if ($validator->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validator->errors()
			], 422);
		}

		// Si pasa la validación:
		$datos = $validator->validated();
		$categoria = CategoriasWeb::create([
			'nombre' => ucfirst($datos['nombre']),
			'slug' => strtolower(Str::slug($datos['nombre'])),
			'vault' => strtolower($datos['vault']),
			'visible' => true
		]);

		// Crea el archivo blade
		$bladeFilePath = resource_path('views/2_vistas/web/singles/' . strtolower($datos['vault']) . '.blade.php');

		if (!file_exists($bladeFilePath)) {
			$plantillaPath = resource_path('views/1_plantilla/loaders/web.blade.php');
			if (file_exists($plantillaPath)) {
				$contenidoPlantilla = file_get_contents($plantillaPath);
				file_put_contents($bladeFilePath, $contenidoPlantilla);
			} else {
				file_put_contents($bladeFilePath, "<!-- Vista para " . ucfirst($datos['vault']) . " -->\n<h1>" . ucfirst($datos['vault']) . "</h1>");
			}
		}

		return response()->json([
			'mensaje' => 'Categoría WEB creada',
			'datos' => $categoria
		], 201);
	}

	public function eliminar_categoria_web(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'slug' => 'required|string|max:50|exists:99_categorias_web',
			'serial' => ['required', new SerialValido],
		]);

		if ($validator->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validator->errors()
			], 422);
		}

		// Si pasa la validación:
		$datos = $validator->validated();
		$categoria = CategoriasWeb::where('slug', strtolower($datos['slug']))->first();

		// Elimina el archivo blade
		$bladeFilePath = resource_path('views/2_vistas/web/singles/' . strtolower($categoria['vault']) . '.blade.php');

		if (file_exists($bladeFilePath)) {
			unlink($bladeFilePath);
		}

		$categoria->delete();

		return response()->json([
			'mensaje' => 'Categoría WEB eliminada',
			'datos' => $categoria
		], 201);
	}

	# Categorias PANEL
	public function crear_categoria_panel(Request $request)
	{
		$slugGenerado = strtolower(Str::slug($request->input('nombre')));

		$validator = Validator::make(array_merge($request->all(), ['slug' => $slugGenerado]), [
			'nombre' => 'required|string|max:50|unique:99_categorias_panel',
			'slug' => 'unique:99_categorias_panel,slug',
			'vault' => 'required|string|max:50|unique:99_categorias_panel',
			'serial' => ['required', new SerialValido],
		]);

		if ($validator->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validator->errors()
			], 422);
		}

		// Si pasa la validación:
		$datos = $validator->validated();
		$categoria = CategoriasPanel::create([
			'nombre' => ucfirst($datos['nombre']),
			'slug' => strtolower(Str::slug($datos['nombre'])),
			'vault' => strtolower($datos['vault']),
			'visible' => true
		]);

		// Crea el archivo blade
		$vaultPath = strtolower($datos['vault']);
		$bladeFilePath = resource_path('views/2_vistas/panel/singles/' . str_replace('.', '/', $vaultPath) . '.blade.php');

		// Crea las carpetas intermedias si no existen
		$directoryPath = dirname($bladeFilePath);
		if (!file_exists($directoryPath)) {
			mkdir($directoryPath, 0755, true);
		}

		if (!file_exists($bladeFilePath)) {
			$plantillaPath = resource_path('views/1_plantilla/loaders/panel.blade.php');
			if (file_exists($plantillaPath)) {
				$contenidoPlantilla = file_get_contents($plantillaPath);
				file_put_contents($bladeFilePath, $contenidoPlantilla);
			} else {
				file_put_contents($bladeFilePath, "<!-- Vista para " . ucfirst($vaultPath) . " -->\n<h1>" . ucfirst($vaultPath) . "</h1>");
			}
		}

		return response()->json([
			'mensaje' => 'Categoría PANEL creada',
			'datos' => $categoria
		], 201);
	}

	public function eliminar_categoria_panel(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'slug' => 'required|string|max:50|exists:99_categorias_panel',
			'serial' => ['required', new SerialValido],
		]);

		if ($validator->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validator->errors()
			], 422);
		}

		// Si pasa la validación:
		$datos = $validator->validated();

		$categoria = CategoriasPanel::where('slug', strtolower($datos['slug']))->first();

		// Elimina el archivo blade
		$vaultPath = strtolower($categoria['vault']);
		$bladeFilePath = resource_path('views/2_vistas/panel/singles/' . str_replace('.', '/', $vaultPath) . '.blade.php');

		// Elimina las carpetas intermedias si están vacías
		if (file_exists($bladeFilePath)) {
			unlink($bladeFilePath);

			$directoryPath = dirname($bladeFilePath);
			while (is_dir($directoryPath) && count(scandir($directoryPath)) == 2) { // Solo contiene '.' y '..'
				rmdir($directoryPath);
				$directoryPath = dirname($directoryPath);
			}
		}

		$categoria->delete();

		return response()->json([
			'mensaje' => 'Categoría PANEL eliminada',
			'datos' => $categoria
		], 201);
	}

	// **** GESTION CRUD INTERNA **** //

	public function crear_stake(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nombre' => 'required|string|max:50|unique:00_stakes',
			'rendimiento' => 'required|numeric|min:0',
			'minimo' => 'required|numeric|min:0',
		]);

		if ($validator->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validator->errors()
			], 422);
		}

		// Si pasa la validación:
		$datos = $validator->validated();
		$stake = Stake::create([
			'uuid' => Str::uuid(),
			'nombre' => ucfirst($datos['nombre']),
			'rendimiento' => $datos['rendimiento'],
			'minimo' => $datos['minimo'],
		]);

		return response()->json([
			'mensaje' => 'Stake creado',
			'datos' => $stake
		], 201);
	}

	public function eliminar_stake(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => 'required|exists:00_stakes,id',
		]);

		if ($validator->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validator->errors()
			], 422);
		}

		// Si pasa la validación:
		$datos = $validator->validated();
		$stake = Stake::find($datos['id']);

		$stake->delete();

		return response()->json([
			'mensaje' => 'Stake eliminado',
			'datos' => $stake
		], 201);
	}

	public function crear_plan_usuario(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'plan_nombre' => 'required|string|max:50|unique:11_planes_usuario',
			'plan_stripe' => 'required|string|max:255|unique:11_planes_usuario',
			'plan_precio' => 'required|numeric|min:0',
			'plan_caracteristicas' => 'required|array',
		]);

		if ($validator->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validator->errors()
			], 422);
		}

		// Si pasa la validación:
		$datos = $validator->validated();
		$planUsuario = PlanesUsuario::create([
			'plan_nombre' => ucfirst($datos['plan_nombre']),
			'plan_stripe' => $datos['plan_stripe'],
			'plan_precio' => $datos['plan_precio'],
			'plan_caracteristicas' => $datos['plan_caracteristicas'],
		]);

		return response()->json([
			'mensaje' => 'Plan de usuario creado',
			'datos' => $planUsuario
		], 201);
	}

	public function eliminar_plan_usuario(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'id' => 'required|exists:11_planes_usuario,id',
		]);

		if ($validator->fails()) {
			return response()->json([
				'mensaje' => 'Errores de validación',
				'errores' => $validator->errors()
			], 422);
		}

		// Si pasa la validación:
		$datos = $validator->validated();
		$planUsuario = PlanesUsuario::find($datos['id']);

		$planUsuario->delete();

		return response()->json([
			'mensaje' => 'Plan de usuario eliminado',
			'datos' => $planUsuario
		], 201);
	}
}
