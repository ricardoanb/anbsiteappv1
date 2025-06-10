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
		Schema::create('99_categorias_web', function (Blueprint $table) {
			$table->id();
			$table->string('nombre')->nullable();
			$table->string('slug')->nullable();
			$table->string('vault')->nullable();
			$table->boolean('visible')->nullable()->default('false');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('99_categorias_web');
	}
};
