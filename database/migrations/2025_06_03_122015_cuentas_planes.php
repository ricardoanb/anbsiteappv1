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
		Schema::create('00_cuentas_planes', function (Blueprint $table) {
			$table->id(); // Auto-incrementing primary key
			$table->string('etiqueta', 100)->comment('Nombre descriptivo de la cuenta (ej. "Mi Billetera Principal", "Cuenta de Ahorros")');
			$table->string('nombre', 100);
			$table->decimal('apy', 100);
			$table->decimal('fees', 100);
			$table->string('stripe_price', 250);
			$table->timestamps(); // created_at and updated_at
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('00_cuentas_planes');
	}
};
