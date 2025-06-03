@extends('1_plantillas.panel')

@section('contenido')
	<!-- Stakes -->
	<div class="space-y-10">
		<div class="aaa">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold text-gray-900">Stakes</h1>
					<p class="mt-2 text-sm text-gray-700">Gestiona tus ahorros y ganancias.</p>
				</div>
			</div>
		</div>

		<!-- Lista -->
		<ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-2 xl:grid-cols-3 xl:gap-x-8">
			@foreach ($stakes as $stake)
				<li class="overflow-hidden rounded-xl border border-gray-200">
					<div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-4">
						@if ($stake->icono != null)
							<img src="{{ storage('/stake_icons/') . $stake->icono }}" alt="Reform" class="size-11 flex-none rounded-lg bg-white object-cover ring-1 ring-gray-900/10">
						@endif
						<div class="text-sm/6 font-medium text-gray-900">{{ $stake->nombre }}</div>

						<div class="ml-auto">
							<button target="{{ $stake->etiqueta }}" type="button" class="select_stake block rounded-md bg-indigo-600 px-2.5 py-1.5 text-center text-xs font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Aplicar</button>
						</div>
					</div>
					<dl class="grid grid-cols-2 divide-x divide-gray-100 text-sm/6">
						<div class="p-4 py-2">
							<dt class="text-gray-500">Rendimiento</dt>
							<dd class="flex items-start gap-x-2">
								<div class="font-medium text-gray-900">{{ $stake->rendimiento }}%</div>
							</dd>
						</div>
						<div class="p-4 py-2">
							<dt class="text-gray-500">Mínimo</dt>
							<dd class="flex items-start gap-x-2">
								<div class="font-medium text-gray-900">{{ number_format($stake->minimo, 0, ',', '.') }}€</div>
							</dd>
						</div>
					</dl>
				</li>
			@endforeach
		</ul>

		<div class="mt-5 flow-root overflow-hidden">
			<div class="aaa">
				<table class="min-w-full divide-y divide-gray-300">
					<thead>
						<tr>
							<th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Moneda</th>
							<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Aportación</th>
							<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Fin</th>
							<th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
								<span class="sr-only">Ver</span>
							</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200">
						@if (count($usuario->userStakes) > 0)
							@foreach ($usuario->userStakes as $stake)
								<tr>
									<td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0">{{ $stake->stakeType->nombre }}</td>
									<td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{ number_format($stake->monto_invertido, 2, ',', '.') }}€ ({{ $stake->stakeType->rendimiento }}%)</td>
									<td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{ Carbon\Carbon::parse($stake->fecha_final)->format('d M Y') }}</td>
									<td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
										<a href="{{ route('panel.stake.single', ['id' => $stake->etiqueta]) }}" class="text-indigo-600 hover:text-indigo-900">Ver<span class="sr-only">, {{ $stake->stakeType->nombre }}</span></a>
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0">No tienes ningún stake asociado.</td>
							</tr>
						@endif

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

				<div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl sm:p-6">

					<form id="lanzar_stake">
						<div class="sm:flex sm:items-start w-full">

							<div class="mt-3 text-center sm:mt-0 sm:text-left">
								<!-- Letrero -->
								<h3 class="text-base font-semibold text-gray-900" id="modal-title">Crear puesto de stake</h3>

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

								<!-- Aviso -->
								<div class="my-5 text-gray-700 space-y-4">
									<div class="rounded-md bg-yellow-50 p-4">
										<div class="flex">
											<div class="shrink-0">
												<svg class="size-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
													<path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
												</svg>
											</div>
											<div class="ml-3">
												<h3 class="text-sm font-medium text-yellow-800">Atención, antes de continuar</h3>
												<div class="mt-2 text-sm text-yellow-700">
													<p>Los modelos de stake están pensados para depositar el dinero de manera en la que no se pueden retirar hasta que se acaba la fecha de dicho contrato. Elige el importe correcto antes de abrir un stake.</p>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Contenido -->
								<div class="cont my-5">
									<div id="step1" class="col-span-2 space-y-3">
										<div class="font-semibold text-gray-900">
											<span class="text-base/7">Tus cuentas</span>
										</div>
										<fieldset aria-label="cuentas" class="col-span-2 relative -space-y-px rounded-md bg-white">
											@foreach ($cuentas as $cuenta)
												<label aria-label="{{ $cuenta->numero_identificador }}" class="group flex cursor-pointer border border-gray-200 p-4 first:rounded-tl-md first:rounded-tr-md last:rounded-br-md last:rounded-bl-md focus:outline-hidden has-checked:relative has-checked:border-indigo-200 has-checked:bg-indigo-50 md:grid md:grid-cols-[1fr_auto] md:pr-6 md:pl-4 justify-between items-center">
													<span class="flex items-center gap-3 text-sm">
														<input name="cuenta_etiqueta" checked value="{{ $cuenta->etiqueta }}" type="radio"
															class="relative size-4 appearance-none rounded-full border border-gray-200 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-200 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden">
														<span class="font-medium text-gray-900 group-has-checked:text-indigo-900">{{ $cuenta->numero_identificador }}</span>
													</span>
													<span class="ml-auto pl-1 text-sm md:ml-0 md:pl-0 md:text-center">
														<span class="font-medium text-gray-900 group-has-checked:text-indigo-900">{{ number_format($cuenta->saldo, 2, ',', '.') }}€</span>
													</span>
												</label>
											@endforeach
										</fieldset>
									</div>

									<div class="my-3">
										<label for="monto_invertido" class="block text-sm/6 font-medium text-gray-900">Account number</label>
										<div class="mt-2 grid grid-cols-1">
											<input type="text" name="monto_invertido" id="monto_invertido" class="col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pr-10 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:pr-9 sm:text-sm/6" placeholder="10000">
										</div>
										<small class="text-gray-500">
											Retiraremos el dinero de tus cuentas automáticamente.
										</small>
									</div>
								</div>
							</div>
						</div>
						<div class="sm:flex">
							<button type="submit" class="lanzarstake inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 sm:w-auto">Lanzar stake</button>
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

	<script>
		function cerrarmodal() {
			$('.modal').addClass('hidden')
		}

		$('.select_stake').on('click', function() {
			let id = $(this).attr('target');
			$('.modal').removeClass('hidden').attr('target', id);
		});

		$('#lanzar_stake').on('submit', function(e) {
			e.preventDefault();
			let stake = $('.modal').attr('target');

			data = new FormData(this);
			data.append('stake_etiqueta', stake);

			$.ajax({
				type: "post",
				url: "{{ route('api.u_stake.crear') }}",
				data: data,
				dataType: "json",
				processData: false,
				contentType: false,
				beforeSend: function() {
					$('button[type=submit]').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
				},
				success: function(response) {
					window.location.reload();
				},
				error: function(res) {
					$('.alerta').removeClass('hidden');
					$('#msgalerta').text(res.responseJSON.msg);

					let errors = res.responseJSON.errors;
					$('button[type=submit]').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);

					if (Array.isArray(errors)) {
						errors.forEach(element => {
							$('#msgalerta').append(`<li>${element}</li>`);
						});
					} else if (typeof errors === 'object' && errors !== null) {
						for (const key in errors) {
							if (errors.hasOwnProperty(key)) {
								errors[key].forEach(element => {
									$('#msgalerta').append(`<li>${element}</li>`);
								});
							}
						}
					}
				}
			});
		})
	</script>
@endsection
