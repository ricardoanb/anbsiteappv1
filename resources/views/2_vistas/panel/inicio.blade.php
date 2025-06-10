@extends('1_plantilla.panel')

@section('contenido')
	<div class="space-y-10">
		<!-- Sección -->
		<div>
			<h3 class="text-base font-semibold text-gray-900">Posición rápida</h3>
			<dl class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">
				<div class="overflow-hidden rounded-lg bg-white px-3 py-4 border border-gray-200 sm:p-5">
					<dt class="truncate text-sm font-medium text-gray-500">Patrimonio</dt>
					<dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">{{ number_format($usuario->saldoTotal(), 2, ',', '.') }}€</dd>
				</div>
				<div class="overflow-hidden rounded-lg bg-white px-3 py-4 border border-gray-200 sm:p-5">
					<dt class="truncate text-sm font-medium text-gray-500">Invertido en stake</dt>
					<dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">{{ number_format($usuario->invertidoStake(), 2, ',', '.') }}€</dd>
				</div>
			</dl>
		</div>

		<!-- Sección -->
		<div>
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold text-gray-900">Últimos movimientos</h1>
					<p class="mt-2 text-sm text-gray-700">Últimos movimientos en tus cuentas</p>
				</div>
			</div>
			<div class="mt-8 flow-root">
				<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
					<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
						<table class="min-w-full divide-y divide-gray-300">
							<thead>
								<tr>
									<th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold whitespace-nowrap text-gray-900 sm:pl-0">Tipo</th>
									<th scope="col" class="px-2 py-3.5 text-left text-sm font-semibold whitespace-nowrap text-gray-900">Origen</th>
									<th scope="col" class="px-2 py-3.5 text-right text-sm font-semibold whitespace-nowrap text-gray-900">Monto</th>
									<th scope="col" class="px-2 py-3.5 text-right text-sm font-semibold whitespace-nowrap text-gray-900">Fecha</th>
								</tr>
							</thead>
							<tbody class="divide-y divide-gray-200 bg-white">

								@if (count($movimientos) > 0)
									@foreach ($movimientos as $mov)
										<tr>
											<td class="py-2 pr-3 pl-4 text-sm whitespace-nowrap text-gray-500 sm:pl-0">{{ $mov->tipo }}</td>

											<td class="px-2 py-2 text-sm whitespace-nowrap text-gray-900">
												<a class="text-blue-500 hover:text-blue-600" href="{{ route('panel_cuenta', ['id' => $mov->cuenta[0]->uuid]) }}">
													{{ $mov->cuenta[0]->numero_cuenta }}
												</a>
											</td>
											<td class="px-2 py-2 text-sm text-right font-medium whitespace-nowrap text-gray-900">
												{{ json_decode($mov->assets)->monto }}
											</td>
											<td class="px-2 py-2 text-sm text-right whitespace-nowrap text-gray-500">
												{{ Carbon\Carbon::parse($mov->created_at)->translatedFormat('d F, H:i\h') }}
											</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="4" class="py-2 pr-3 pl-4 text-sm whitespace-nowrap text-gray-500 sm:pl-0">
											No tienes ningún movimiento en ANB.
										</td>
									</tr>
								@endif

								<!-- More transactions... -->
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
@endsection
