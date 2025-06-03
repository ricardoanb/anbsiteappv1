@extends('1_plantillas.panel')

@section('contenido')
	<!-- Cuenta -->
	<dl class="border border-gray-200 grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white md:grid-cols-2 md:divide-x md:divide-y-0">
		<div class="p-4 sm:p-4">
			<dt class="text-sm font-normal text-gray-900">Saldo</dt>
			<dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
				<div class="flex items-baseline text-xl font-semibold text-gray-900">
					{{ number_format($usuario->cuentas->saldo, 2, ',', '.') }}€
					<span class="ml-2 text-sm font-medium text-gray-900"></span>
				</div>
			</dd>
		</div>
		<div class="p-4 sm:p-4">
			<dt class="text-sm font-normal text-gray-900">Cuenta</dt>
			<dd class="mt-1 w-full md:block lg:flex">
				<div class="flex w-full justify-between text-xl font-semibold text-gray-900">
					<span>{{ substr($usuario->cuentas->numero_identificador, -20) }}</span>
					<button onclick="copyIban()" class="bg-gray-900 hover:bg-gray-900 cursor-pointer rounded text-xs px-2 py-1 ml-auto text-sm font-medium text-white">
						Copiar
					</button>
				</div>
			</dd>
		</div>
	</dl>

	<!-- Transacciones -->
	<div class="sec">
		<div class="aaa">
			<div class="sm:flex sm:items-center">
				<div class="w-full flex items-center justify-between">

					<div class="caja">
						<h1 class="text-base font-semibold text-gray-900">Transacciones</h1>
						<p class="mt-2 text-sm text-gray-700">Todas tus transacciones de la cuenta.</p>
					</div>

					<div class="caja">
						<a href="{{ route('panel.enviar') }}">
							<button class="text-xs bg-indigo-500 hover:bg-indigo-600 cursor-pointer text-white px-3 py-2 rounded-md">
								Enviar dinero
							</button>
						</a>
					</div>

				</div>
			</div>
		</div>
		<div class="mt-5 flow-root overflow-hidden">
			<div class="aaa">

				<table class="min-w-full divide-y divide-gray-300">
					<thead>
						<tr>
							<th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold whitespace-nowrap text-gray-900 sm:pl-0"></th>
							<th scope="col" class="px-2 py-3.5 text-left text-sm font-semibold whitespace-nowrap text-gray-900">Tipo</th>
							<th scope="col" class="px-2 py-3.5 text-left text-sm font-semibold whitespace-nowrap text-gray-900">Monto</th>
							<th scope="col" class="px-2 py-3.5 text-left text-sm font-semibold whitespace-nowrap text-gray-900">Fecha</th>

							<th scope="col" class="relative py-3.5 pr-4 pl-3 whitespace-nowrap sm:pr-0">
								<span class="sr-only">Edit</span>
							</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 bg-white">

						@if (count($usuario->cuentas->allTransactions()) > 0)
							@foreach ($usuario->cuentas->allTransactions() as $movimiento)
								<tr>
									<td class="px-2 py-2 text-sm whitespace-nowrap text-gray-500">
										@switch($movimiento->tipo)
											@case('deposito')
												<div class="flex items-start gap-3">
													<img class="size-6" src="{{ asset('/icons/walletplus.svg') }}" alt="">
												</div>
											@break

											@case('retiro')
												<div class="flex items-start gap-3">
													<img class="size-6" src="{{ asset('/icons/walletminus.svg') }}" alt="">
												</div>
											@break

											@case('transferencia_interna')
												<div class="flex items-start gap-3">
													<img class="size-6" src="{{ asset('/icons/transfer.svg') }}" alt="">
												</div>
											@break

											@case('pago')
												<div class="flex items-start gap-3">
													<img class="size-6" src="{{ asset('/icons/walletminus.svg') }}" alt="">
												</div>
											@break

											@case('reembolso')
												<div class="flex items-start gap-3">
													<img class="size-6" src="{{ asset('/icons/refund.svg') }}" alt="">
												</div>
											@break

											@case('comision')
												<div class="flex items-start gap-3">
													<img class="size-6" src="{{ asset('/icons/fees.svg') }}" alt="">
												</div>
											@break

											@case('rendimiento_stake')
												<div class="flex items-start gap-3">
													<img class="size-6" src="{{ asset('/icons/safebox.svg') }}" alt="">
												</div>
											@break

											@default
										@endswitch
									</td>

									<td class="px-2 py-2 text-sm whitespace-nowrap text-gray-500">
										@switch($movimiento->tipo)
											@case('deposito')
												<span>{{ ucfirst($movimiento->tipo) }}</span>
											@break

											@case('retiro')
												<span>{{ ucfirst($movimiento->tipo) }}</span>
											@break

											@case('transferencia_interna')
												<span>Transferencia interna</span>
											@break

											@case('pago')
												<span>{{ ucfirst($movimiento->tipo) }}</span>
											@break

											@case('reembolso')
												<span>{{ ucfirst($movimiento->tipo) }}</span>
											@break

											@case('comision')
												<span>{{ ucfirst($movimiento->tipo) }}</span>
											@break

											@case('rendimiento_stake')
												<span>Rendimiento en stake</span>
											@break

											@default
										@endswitch
									</td>

									<td class="px-2 py-2 text-sm font-medium whitespace-nowrap text-gray-900">{{ number_format($movimiento->monto, 2, ',', '.') }}€</td>

									<td class="px-2 py-2 text-sm whitespace-nowrap text-gray-900">{{ Carbon\Carbon::parse($movimiento->created_at)->format('d F l \a \l\a\s H:i:s') }}</td>

									<td class="relative py-2 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
										<a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, AAPS0L</span></a>
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0">No hay movimientos</td>
							</tr>
						@endif

					</tbody>
				</table>
			</div>
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
				console.log(response);
				window.location.reload();
			}
		});
	</script>
@endsection
