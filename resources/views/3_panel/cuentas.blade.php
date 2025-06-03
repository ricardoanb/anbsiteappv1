@extends('1_plantillas.panel')

@section('contenido')
	<!-- Cuentas -->
	<div class="sec">
		<div class="aaa">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold text-gray-900">Cuentas</h1>
					<p class="mt-2 text-sm text-gray-700">Gestiona tus cuentas de un solo vistazo.</p>
				</div>
				<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
					<button type="button" class="block rounded-md bg-indigo-600 px-2.5 py-1.5 text-center text-xs font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" onclick="abrirmodal()">Abrir cuenta</button>
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
@endsection

@section('modales')
	<div class="relative hidden modal z-100" aria-labelledby="modal-title" role="dialog" aria-modal="true">
		<div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
		<div class="fixed inset-0 z-10 w-screen overflow-y-auto">
			<div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

				<div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
					<form id="nueva_cuenta">
						<!-- Alerta -->
						<div class="my-4 alerta hidden">

							<div class="rounded-md bg-red-50 p-4">
								<div class="flex">
									<div class="shrink-0">
										<svg class="size-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
											<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
										</svg>
									</div>
									<div class="ml-3">
										<h3 class="text-sm font-medium text-red-800">Ha ocurrido un error</h3>
										<div class="mt-2 text-sm text-red-700">
											<span id="msgalerta"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="sm:flex sm:items-start w-full">

							<div class="mt-3 text-center sm:mt-0 sm:text-left">
								<h3 class="text-base font-semibold text-gray-900" id="modal-title">Abrir nueva cuenta</h3>
								<div class="my-7 text-gray-700 space-y-4">
									<p>
										La apertura de una cuenta dentro de ANB tiene un coste de mantenimiento integrado. Este precio puede cambiar más adelante.
									</p>

									<fieldset aria-label="Pricing plans" class="relative -space-y-px rounded-md bg-white">
										@foreach ($planes_cuentas as $plan)
											<label aria-label="{{ $plan->nombre }}" class="group flex cursor-pointer flex-col border border-gray-200 p-4 first:rounded-tl-md first:rounded-tr-md last:rounded-br-md last:rounded-bl-md focus:outline-hidden has-checked:relative has-checked:border-indigo-200 has-checked:bg-indigo-50 md:grid md:grid-cols-2 md:pr-6 md:pl-4">
												<span class="flex items-center gap-3 text-sm">
													<input name="pricing-plan" value="{{ $plan->etiqueta }}" type="radio" checked
														class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden">
													<span class="font-medium text-gray-900 group-has-checked:text-indigo-900">{{ $plan->nombre }}</span>
												</span>
												<span class="pl-1 text-sm text-gray-500 group-has-checked:text-indigo-700 md:ml-0 md:pl-0 md:text-right">APY: {{ $plan->apy }} - Fees: {{ $plan->fees }}%</span>
											</label>
										@endforeach
									</fieldset>
								</div>
							</div>
						</div>
						<div class="sm:flex">
							<button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 sm:w-auto">Crear cuenta</button>
							<button type="button" onclick="cerrarmodal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto">Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		function abrirmodal() {
			$('.modal').removeClass('hidden')
		}

		function cerrarmodal() {
			$('.modal').addClass('hidden')
		}
		$('#nueva_cuenta').on('submit', function(event) {
			event.preventDefault();
			let data = new FormData(this);

			$.ajax({
				type: "post",
				url: "{{ route('api.cuenta.crear') }}",
				data: data,
				dataType: "json",
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('.alerta').addClass('hidden');
					$('#nueva_cuenta').find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
				},
				success: function(response) {
					console.log(response)
					window.location.href = response.url;
					//$('#nueva_cuenta').find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
				},
				error: function(response) {
					$('#nueva_cuenta').find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
					$('.alerta').removeClass('hidden');
					$('#msgalerta').text(response.responseJSON.msg);
				}
			});
		})
	</script>
@endsection
