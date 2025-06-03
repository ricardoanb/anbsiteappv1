@extends('1_plantillas.panel')

@section('contenido')
	<!-- Stakes -->
	<div class="sec space-y-10">
		<div class="aaa">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold text-gray-900">Información de stake</h1>
					<p class="mt-2 text-sm text-gray-700">#{{ $stake->etiqueta }}</p>
				</div>
			</div>
		</div>
		<div class="aaa">
			<dl class="mt-5 border border-gray-200 grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white md:grid-cols-2 md:divide-x md:divide-y-0">
				<div class="p-4 sm:p-4">
					<dt class="text-sm font-normal text-gray-900">Aporte inicial</dt>
					<dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
						<div class="flex items-baseline text-xl font-semibold text-indigo-600">
							{{ number_format($stake->monto_invertido, 2, ',', '.') }}€
							<span class="ml-2 text-sm font-medium text-gray-500"></span>
						</div>
					</dd>
				</div>
				<div class="p-4 sm:p-4">
					<dt class="text-sm font-normal text-gray-900">Generado</dt>
					<dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
						<div class="flex items-baseline text-xl font-semibold text-green-600">

							@php
								use Carbon\Carbon;

								$fechaInicio = Carbon::parse($stake->fecha_inicio);
								$fechaFin = Carbon::parse($stake->fecha_fin); // Asumiendo que tienes una fecha_fin
								$duracionTotalDias = $fechaInicio->diffInDays($fechaFin);

								// Evitar división por cero si la duración es 0 o indefinida
								if ($duracionTotalDias === 0) {
								    $rendimientoDiarioPorcentaje = 0; // O manejar como error
								    $gananciaAcumuladaHastaHoy = 0;
								    $valorActual = $stake->monto_invertido;
								} else {
								    // Suponiendo que $stake->stakeType->rendimiento es un valor numérico (ej. 10 para 10%)
								    // o un factor (ej. 0.10 para 10%)
								    $rendimientoTotalDecimal = $stake->stakeType->rendimiento / 100; // Si es un porcentaje entero como 10

								    // Ganancia total esperada para el stake
								    $gananciaTotalEsperada = $stake->monto_invertido * $rendimientoTotalDecimal;

								    // Ganancia diaria promedio (en valor monetario)
								    $gananciaDiariaValor = $gananciaTotalEsperada / $duracionTotalDias;

								    // Porcentaje de ganancia diario (basado en el monto invertido)
								    $rendimientoDiarioPorcentaje = ($gananciaDiariaValor / $stake->monto_invertido) * 100;

								    // Días transcurridos hasta hoy
								    $diasHastaHoy = $fechaInicio->diffInDays(Carbon::now());
								    // Asegúrate de que no se pase de la fecha de fin
								    if ($diasHastaHoy > $duracionTotalDias) {
								        $diasHastaHoy = $duracionTotalDias; // Ya alcanzó o superó la fecha de fin
								    }

								    // Ganancia acumulada hasta hoy
								    $gananciaAcumuladaHastaHoy = $gananciaDiariaValor * $diasHastaHoy;

								    // Valor actual del stake
								    $valorActual = $gananciaAcumuladaHastaHoy;
								}
							@endphp
							<span>{{ number_format($valorActual, 2, ',', '.') }}€</span>
							<span class="ml-2 text-sm font-medium text-gray-500"></span>
						</div>
					</dd>
				</div>
			</dl>
		</div>

	</div>
@endsection

@section('scripts')
	<script>
		data = {
			'token': localStorage.getItem('token')
		};

		$.ajax({
			type: "get",
			url: "{{ route('api.usuario.get') }}",
			data: data,
			dataType: "json",
			success: function(response) {
				console.log(response)
			}
		});
	</script>
@endsection
