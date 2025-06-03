@extends('1_plantillas.panel')

@section('contenido')
	<div class="sec">
		<h3 class="text-base font-semibold text-gray-900">Información de la cuenta</h3>
		<dl class="mt-5 border border-gray-200 grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white md:grid-cols-3 md:divide-x md:divide-y-0">
			<div class="p-4 sm:p-4">
				<dt class="text-sm font-normal text-gray-900">Patrimonio</dt>
				<dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
					<div class="flex items-baseline text-xl font-semibold text-gray-900">
						<span>{{ number_format($patrimonio, 2, ',', '.') }}€</span>
						<span class="ml-2 text-sm font-medium text-gray-500"></span>
					</div>
				</dd>
			</div>
			<div class="p-4 sm:p-4">
				<dt class="text-sm font-normal text-gray-900">Usuario</dt>
				<dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
					<div class="flex items-baseline text-xl font-semibold text-gray-900">
						#{{ $usuario->etiqueta }}
						<span class="ml-2 text-sm font-medium text-gray-500"></span>
					</div>
				</dd>
			</div>
			<div class="p-4 sm:p-4">
				<dt class="text-sm font-normal text-gray-900">Stake</dt>
				<dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
					<div class="flex items-baseline text-xl font-semibold text-gray-900">
						0,00€
						<span class="ml-2 text-sm font-medium text-gray-500"></span>
					</div>
				</dd>
			</div>
		</dl>
	</div>

	<!-- Cuentas -->
	<div class="sec">
		<div class="aaa">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold text-gray-900">Cuentas</h1>
					<p class="mt-2 text-sm text-gray-700">Gestiona tus cuentas de un solo vistazo.</p>
				</div>
			</div>
		</div>
		<div class="mt-5 flow-root overflow-hidden">
			<div class="aaa">
				<table class="w-full text-left">
					<thead class="bg-white">
						<tr>
							<th scope="col" class="relative isolate py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">
								Cuenta
								<div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-b-gray-200"></div>
								<div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-b-gray-200"></div>
							</th>
							<th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Disponible</th>
							<th scope="col" class="relative py-3.5 pl-3">
								<span class="sr-only">Ver</span>
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($usuario->cuentas as $cuenta)
							<tr>
								<td class="relative py-4 pr-3 text-sm font-medium text-gray-900">
									****{{ substr($cuenta->numero_identificador, -4) }}
									<div class="absolute right-full bottom-0 h-px w-screen bg-gray-100"></div>
									<div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100"></div>
								</td>
								<td class="px-3 py-4 text-sm text-gray-500 text-end">{{ number_format($cuenta->saldo, 2, ',', '.') }}€</td>
								<td class="relative py-4 pl-3 text-right text-sm font-medium">
									<a href="{{ route('panel.cuenta.single', ['id' => $cuenta->etiqueta]) }}" class="text-indigo-600 hover:text-indigo-900">Ver<span class="sr-only">, **** 0123</span></a>
								</td>
							</tr>
						@endforeach

						<!-- More people... -->
					</tbody>
				</table>
			</div>
		</div>

	</div>

	<!-- Tarjetas -->
	<div class="sec hidden">
		<div class="aaa">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold text-gray-900">Tarjetas</h1>
					<p class="mt-2 text-sm text-gray-700">Todas tus tarjetas de ANB.</p>
				</div>
				<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
					<button type="button" class="block rounded-md bg-indigo-600 px-2.5 py-1.5 text-center text-xs font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Crear tarjeta</button>
				</div>
			</div>
		</div>
		<div class="mt-5 flow-root overflow-hidden">
			<div class="aaa">
				<table class="min-w-full divide-y divide-gray-300">
					<thead>
						<tr>
							<th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Número</th>
							<th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Disponible</th>
							<th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
								<span class="sr-only">Ver</span>
							</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200">
						<tr>
							<td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0">**** 0000</td>
							<td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 text-right">235,33€</td>
							<td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
								<a href="{{ route('panel.tarjeta.single', ['id' => 1]) }}" class="text-indigo-600 hover:text-indigo-900">Ver<span class="sr-only">, Bitcoin</span></a>
							</td>
						</tr>

						<!-- More people... -->
					</tbody>
				</table>
			</div>
		</div>

	</div>

	<!-- Stakes -->
	@if ($usuario->userStakes != [])
		<div class="sec">
			<div class="aaa">
				<div class="sm:flex sm:items-center">
					<div class="sm:flex-auto">
						<h1 class="text-base font-semibold text-gray-900">Stakes</h1>
						<p class="mt-2 text-sm text-gray-700">Gestiona tus ahorros y ganancias.</p>
					</div>
				</div>
			</div>
			<div class="mt-5 flow-root overflow-hidden">
				<div class="aaa">
					<table class="min-w-full divide-y divide-gray-300">
						<thead>
							<tr>
								<th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Monto invertido</th>
								<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Estado</th>
								<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Fin</th>
								<th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
									<span class="sr-only">Ver</span>
								</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-200">
							@foreach ($usuario->userStakes as $stake)
								<tr>
									<td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0">{{ number_format($stake->monto_invertido, 2, ',', '.') }}€</td>
									<td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{ $stake->estado }}</td>
									<td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{ Carbon\Carbon::parse($stake->fecha_final)->format('d/m/Y') }}</td>
									<td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
										<a href="{{ route('panel.stake.single', ['id' => $stake->etiqueta]) }}" class="text-indigo-600 hover:text-indigo-900">Ver<span class="sr-only">, Bitcoin</span></a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

		</div>
	@endif
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
