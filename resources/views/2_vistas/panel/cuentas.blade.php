@extends('1_plantilla.panel')

@section('contenido')
	<div class="space-y-12 max-w-5xl">

		<div class="">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold text-gray-900">Cuentas</h1>
					<p class="mt-2 text-sm text-gray-700">Lista de todas las cuentas.</p>
				</div>
				<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
					<a href="{{ route('panel_nueva') }}">
						<button type="button" class="block rounded-md bg-indigo-600 px-2.5 py-1.5 text-center text-xs font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-pointer">Abrir cuenta</button>
					</a>
				</div>
			</div>
			<div class="mt-8 flow-root">
				<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
					<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
						<table class="min-w-full divide-y divide-gray-300">
							<thead>
								<tr>
									<th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Nº de cuenta</th>
									<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Saldo</th>
									<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tipo</th>
									<th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
										<span class="sr-only">Acceder</span>
									</th>
								</tr>
							</thead>
							<tbody class="divide-y divide-gray-200">

								@if (count($cuentas) > 0)
									@foreach ($cuentas as $cuenta)
										<tr>
											<td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0">•••• {{ substr($cuenta->numero_cuenta, -4) }}</td>
											<td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{ number_format($cuenta->saldo, 2, ',', '.') }}€</td>
											<td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{ $cuenta->planCuenta->tipo_cuenta }}</td>
											<td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
												<a href="{{ route('panel_cuenta', ['id' => $cuenta->uuid]) }}" class="text-indigo-600 hover:text-indigo-900">Acceder<span class="sr-only">, {{ $cuenta->numero_cuenta }}</span></a>
											</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="4" class="py-2 pr-3 pl-4 text-sm whitespace-nowrap text-gray-500 sm:pl-0">
											No tienes ningún movimiento en esta cuenta.
										</td>
									</tr>
								@endif



								<!-- More people... -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
@endsection
