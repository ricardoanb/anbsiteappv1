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
		Schema::create('00_archivos', function (Blueprint $table) {
			$table->id();
			$table->string('etiqueta');
			$table->string('archivo');
			$table->timestamps();
			//
			$table->unsignedBigInteger('usuario');
			$table->foreign('usuario')->references('id')->on('00_usuarios')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('00_archivos');
	}
};
