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
		// Movimientos
		Schema::create('22_movimientos_cuenta', function (Blueprint $table) {
			$table->id();
			$table->string('uuid');
			$table->foreignId('usuario_id')->constrained('00_usuarios')->onDelete('cascade');
			$table->foreignId('cuenta_id')->constrained('00_cuentas')->onDelete('cascade');
			$table->string('tipo');
			$table->string('estado');
			$table->decimal('monto', 10, 2);
			$table->json('assets')->nullable();
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
