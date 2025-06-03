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

		Schema::create('00_cuentas', function (Blueprint $table) {
			$table->id(); // Auto-incrementing primary key
			$table->string('etiqueta', 100)->comment('Nombre descriptivo de la cuenta (ej. "Mi Billetera Principal", "Cuenta de Ahorros")');
			$table->string('numero_identificador', 255)->nullable()->comment('Token de Stripe para una tarjeta, ID de cuenta externa o número de cuenta de la billetera interna.');
			$table->enum('estado', ['activa', 'inactiva', 'bloqueada'])->default('activa')->comment('Estado actual de la cuenta (ej. activa, inactiva, bloqueada)');
			$table->decimal('saldo', 15, 2)->default(0.00)->comment('Saldo actual de la cuenta. Usar decimal para montos monetarios.');
			$table->timestamps(); // created_at and updated_at

			// Foreign key para el usuario propietario de la cuenta
			$table->unsignedBigInteger('plan');
			$table->foreign('plan')->references('id')->on('00_cuentas_planes')->onDelete('restrict');

			// Foreign key para el usuario propietario de la cuenta
			$table->unsignedBigInteger('usuario');
			$table->foreign('usuario')->references('id')->on('00_usuarios')->onDelete('cascade');
		});

		Schema::create('00_tarjetas', function (Blueprint $table) {
			$table->id();
			$table->string('etiqueta', 100)->comment('Nombre descriptivo de la tarjeta (ej. "Tarjeta principal", "Tarjeta de trabajo")');
			$table->string('stripe_card_id', 255)->unique()->comment('ID de la tarjeta proporcionado por Stripe (token). ESTO ES CRÍTICO PARA LA SEGURIDAD.');
			$table->string('last4', 4)->nullable()->comment('Últimos 4 dígitos del número de tarjeta (seguro para almacenar y mostrar).');
			$table->string('brand', 50)->nullable()->comment('Marca de la tarjeta (Visa, Mastercard, Amex, etc.).');
			$table->string('exp_month', 2)->nullable()->comment('Mes de expiración de la tarjeta (MM).');
			$table->string('exp_year', 4)->nullable()->comment('Año de expiración de la tarjeta (YYYY).');
			$table->enum('estado', ['activa', 'inactiva', 'expirada', 'bloqueada'])->default('activa')->comment('Estado de la tarjeta (ej. activa, inactiva, expirada)');
			$table->timestamps();

			// Foreign key para el usuario propietario de la tarjeta
			$table->unsignedBigInteger('usuario');
			$table->foreign('usuario')->references('id')->on('00_usuarios')->onDelete('cascade');

			// Foreign key para la cuenta a la que está asociada la tarjeta (si aplica)
			$table->unsignedBigInteger('cuenta');
			$table->foreign('cuenta')->references('id')->on('00_cuentas')->onDelete('cascade');
		});

		// Stakes
		Schema::create('00_stakes', function (Blueprint $table) {
			$table->id();
			$table->string('etiqueta', 100)->unique()->comment('Identificador único legible para el stake (ej. "STK_BTC_001")');
			$table->string('nombre', 100)->comment('Nombre descriptivo del plan de stake (ej. "Staking de Bitcoin Flexible")');
			$table->decimal('rendimiento', 5, 2)->comment('Rendimiento anual o tasa de interés (ej. 5.25 para 5.25%).'); // decimal para porcentajes
			$table->decimal('minimo', 15, 2)->comment('Monto mínimo requerido para invertir en este stake.'); // decimal para montos monetarios
			$table->string('moneda', 10)->comment('Moneda o criptomoneda del stake (ej. USD, BTC, ETH).');
			$table->string('icono', 255)->nullable()->comment('Ruta al icono o clase CSS del icono.'); // string para ruta/clase
			$table->enum('estado', ['activo', 'inactivo', 'completo'])->default('activo')->comment('Estado del plan de stake (ej. activo, inactivo).');
			$table->timestamps();
		});

		// Stake de usuario
		Schema::create('00_stake_usuario', function (Blueprint $table) {
			$table->id();
			$table->string('etiqueta', 100)->comment('Etiqueta o ID de referencia para el stake del usuario.');
			$table->decimal('monto_invertido', 15, 2)->comment('Monto que el usuario invirtió en este stake.'); // Añadir monto
			$table->decimal('rendimiento_obtenido', 15, 2)->default(0.00)->comment('Rendimiento acumulado de este stake.'); // Opcional, para seguimiento
			$table->timestamp('fecha_inicio')->comment('Fecha y hora de inicio del stake del usuario.'); // timestamp
			$table->timestamp('fecha_final')->nullable()->comment('Fecha y hora de finalización prevista o real del stake.'); // timestamp, nullable si es flexible
			$table->enum('estado', ['activo', 'finalizado', 'cancelado', 'pendiente'])->default('activo')->comment('Estado del stake para el usuario.');
			$table->timestamps();

			// Foreign key para el usuario
			$table->unsignedBigInteger('usuario');
			$table->foreign('usuario')->references('id')->on('00_usuarios')->onDelete('cascade');

			// Foreign key para la cuenta desde la que se invirtió o a la que se asocia
			$table->unsignedBigInteger('cuenta');
			$table->foreign('cuenta')->references('id')->on('00_cuentas')->onDelete('cascade');

			// Foreign key para el tipo de stake (de la tabla 00_stakes)
			$table->unsignedBigInteger('stake_id'); // Asegúrate de que esta FK exista y apunte a 00_stakes
			$table->foreign('stake_id')->references('id')->on('00_stakes')->onDelete('cascade');
		});

		// Transacciones de usuario
		Schema::create('00_transacciones_usuario', function (Blueprint $table) {
			$table->id();
			$table->string('etiqueta', 100)->nullable()->comment('Etiqueta o descripción de la transacción.');
			$table->timestamp('fecha')->useCurrent()->comment('Fecha y hora exacta de la transacción.'); // timestamp, useCurrent para valor por defecto
			$table->enum('tipo', ['deposito', 'retiro', 'transferencia_interna', 'pago', 'reembolso', 'comision', 'rendimiento_stake'])->comment('Tipo de transacción (ej. depósito, retiro, transferencia).');
			$table->decimal('monto', 15, 2)->comment('Monto de la transacción.');

			// Claves foráneas para las cuentas involucradas.
			// Pueden ser nullable si la transacción es con una cuenta externa a la plataforma.
			$table->unsignedBigInteger('cuenta_saliente')->nullable()->comment('ID de la cuenta de origen si aplica.');
			$table->unsignedBigInteger('cuenta_entrante')->nullable()->comment('ID de la cuenta de destino si aplica.');
			$table->unsignedBigInteger('tarjeta_id')->nullable()->comment('ID de la tarjeta utilizada para la transacción si aplica.'); // Referencia a 00_tarjetas

			$table->enum('estado', ['completada', 'pendiente', 'fallida', 'revertida'])->default('pendiente')->comment('Estado de la transacción.');
			$table->timestamps();

			// Foreign key para el usuario propietario de la transacción
			$table->unsignedBigInteger('usuario');
			$table->foreign('usuario')->references('id')->on('00_usuarios')->onDelete('cascade');

			// Foreign keys para las cuentas y tarjeta
			$table->foreign('cuenta_saliente')->references('id')->on('00_cuentas')->onDelete('cascade');
			$table->foreign('cuenta_entrante')->references('id')->on('00_cuentas')->onDelete('cascade');
			$table->foreign('tarjeta_id')->references('id')->on('00_tarjetas')->onDelete('cascade');
		});

		// KyC tabla
		Schema::create('00_kyc_usuarios', function (Blueprint $table) {
			$table->id();
			$table->string('etiqueta', 100)->nullable()->comment('Etiqueta o descripción de la transacción.');

			$table->string('nombre_completo', 255)->comment('Nombre completo del usuario.');
			$table->string('fecha_nacimiento')->nullable()->comment('Fecha de nacimiento del usuario.');
			$table->enum('tipo_documento', ['dni', 'nif', 'pasaporte', 'licencia_conducir'])->comment('Tipo de documento de identidad.');
			$table->string('numero_documento', 50)->unique()->comment('Número de documento de identidad.');
			$table->string('pais_emision', 100)->nullable()->comment('País de emisión del documento.');
			$table->string('direccion', 255)->nullable()->comment('Dirección de residencia del usuario.');
			$table->string('codigo_postal', 20)->nullable()->comment('Código postal de la dirección del usuario.');
			$table->string('ciudad', 100)->nullable()->comment('Ciudad de residencia del usuario.');
			$table->string('provincia', 100)->nullable()->comment('Provincia o estado de residencia del usuario.');
			$table->string('pais_residencia', 100)->nullable()->comment('País de residencia del usuario.');
			$table->string('telefono', 20)->nullable()->comment('Número de teléfono del usuario.');
			$table->string('correo_electronico', 255)->nullable()->comment('Correo electrónico del usuario.');
			$table->string('fuente_fondos', 255)->nullable()->comment('Descripción de la fuente de los fondos del usuario.');
			$table->text('documento_frontal')->nullable()->comment('Imagen del frente del documento de identidad.');
			$table->text('documento_trasero')->nullable()->comment('Imagen del reverso del documento de identidad.');
			$table->text('selfie_documento')->nullable()->comment('Selfie del usuario sosteniendo el documento de identidad.');

			$table->enum('estado', ['completada', 'pendiente', 'fallida', 'revertida'])->default('pendiente')->comment('Estado de la transacción.');
			$table->timestamps();

			// Foreign key para el usuario propietario de la transacción
			$table->unsignedBigInteger('usuario');
			$table->foreign('usuario')->references('id')->on('00_usuarios')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('00_cuentas_planes');
		Schema::dropIfExists('00_cuentas');
		Schema::dropIfExists('00_tarjetas');
		Schema::dropIfExists('00_stakes');
		Schema::dropIfExists('00_stake_usuario');
		Schema::dropIfExists('00_kyc_usuarios');
		Schema::dropIfExists('00_transacciones_usuario');
	}
};
