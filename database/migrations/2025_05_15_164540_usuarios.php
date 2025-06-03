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
		Schema::create('00_usuarios', function (Blueprint $table) {
			$table->id();
			$table->string('etiqueta');
			$table->string('nombre_usuario');
			$table->string('nombre');
			$table->string('apellido_1');
			$table->string('apellido_2');
			$table->string('telefono');
			$table->string('estado');
			$table->string('avatar');
			$table->string('rol');
			$table->string('remember_token', 400)->nullable();
			$table->string('correo')->unique();
			$table->timestamp('verificacion_correo')->nullable();
			$table->string('password');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('00_usuarios');
	}
};
