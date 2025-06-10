<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		// PLANES USUARIO
		Schema::create('11_planes_usuario', function (Blueprint $table) {
			$table->id();
			$table->string('uuid');
			$table->string('plan_nombre');
			$table->string('plan_stripe');
			$table->string('plan_precio');
			$table->json('plan_caracteristicas')->nullable();

			$table->timestamps();
		});

		// Usuarios
		Schema::create('00_usuarios', function (Blueprint $table) {
			$table->id();
			$table->string('uuid');
			$table->string('etiqueta');
			$table->string('nombre');
			$table->string('apellido_1');
			$table->string('apellido_2');
			$table->string('nombre_usuario');
			$table->string('correo')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->foreignId('plan_usuario_id')->nullable()->constrained('11_planes_usuario')->onDelete('cascade');
			$table->rememberToken();
			$table->timestamps();
		});

		// PLANES CUENTAS
		Schema::create('11_planes_cuentas', function (Blueprint $table) {
			$table->id();
			$table->string('uuid');
			$table->string('tipo_cuenta');
			$table->string('stripe_plan_id')->nullable()->unique();
			$table->decimal('precio', 10, 2);
			$table->json('caracteristicas')->nullable();
			$table->decimal('interes', 10, 2);
			$table->timestamps();
		});

		// KYC
		Schema::create('00_kyc', function (Blueprint $table) {
			$table->id();
			$table->string('uuid');
			$table->foreignId('usuario_id')->constrained('00_usuarios')->onDelete('cascade');
			$table->string('estado');
			$table->string('telefono');
			$table->string('fecha_nacimiento');
			$table->string('pais_nacimiento');
			$table->string('pais_origen');
			$table->string('numero_documento');
			$table->string('tipo_documento');
			$table->string('direccion_postal');
			$table->string('codigo_postal');
			$table->string('ciudad');
			$table->string('provincia');
			$table->string('foto_selfie');
			$table->string('anverso_documento');
			$table->string('reverso_documento');
			$table->timestamps();
		});

		// Cuentas
		Schema::create('00_cuentas', function (Blueprint $table) {
			$table->id();
			$table->string('uuid');
			$table->string('numero_cuenta');
			$table->string('nombre_cuenta');
			$table->decimal('saldo', 10, 2);
			$table->string('estado')->default('activo');
			$table->foreignId('usuario_id')->constrained('00_usuarios')->onDelete('cascade');
			$table->foreignId('plan_cuenta_id')->constrained('11_planes_cuentas')->onDelete('cascade');
			$table->timestamps();
		});

		// Stakes
		Schema::create('00_stakes', function (Blueprint $table) {
			$table->id();
			$table->string('uuid');
			$table->string('nombre');
			$table->decimal('rendimiento', 10, 2);
			$table->decimal('minimo', 10, 2);
			$table->string('duracion');
			$table->timestamps();
		});

		// Stakes usuarios
		Schema::create('00_stakes_usuarios', function (Blueprint $table) {
			$table->id();
			$table->string('uuid');
			$table->foreignId('usuario_id')->constrained('00_usuarios')->onDelete('cascade');
			$table->foreignId('stake_id')->constrained('00_stakes')->onDelete('cascade');
			$table->decimal('monto', 10, 2);
			$table->timestamp('fin');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('00_usuarios');
		Schema::dropIfExists('00_kyc');
		Schema::dropIfExists('00_cuentas');
		Schema::dropIfExists('00_stakes');
		Schema::dropIfExists('00_stakes_usuarios');
		Schema::dropIfExists('11_planes_usuario');
		Schema::dropIfExists('11_planes_cuentas');
	}
};
