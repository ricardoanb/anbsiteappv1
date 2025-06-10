@extends('1_plantilla.panel')

@section('contenido')
	<div class="space-y-12 max-w-5xl">
		<div class="hidden">
			<h1 class="font-bold text-gray-800 text-xl mb-7">
				Panel
			</h1>
		</div>

		<!-- Stakes -->
		<div class="space-y-5">
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
						<div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-3">
							<div class="text-sm/6 font-medium text-gray-900">{{ $stake->nombre }}</div>

							<div class="ml-auto">
								<button target="{{ $stake->uuid }}" type="button" class="abrir_modal cursor-pointer select_stake block rounded-md bg-indigo-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Aplicar</button>
							</div>
						</div>
						<dl class="grid grid-cols-2 divide-x divide-gray-100 text-sm/6">
							<div class="p-3 py-2">
								<dt class="text-gray-500">Rendimiento</dt>
								<dd class="flex items-start gap-x-2">
									<div class="font-medium text-gray-900">{{ $stake->rendimiento }}%</div>
								</dd>
							</div>
							<div class="p-3 py-2">
								<dt class="text-gray-500">Mínimo</dt>
								<dd class="flex items-start gap-x-2">
									<div class="font-medium text-gray-900">{{ number_format($stake->minimo, 2, ',', '.') }}€</div>
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
								<th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Stake</th>
								<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Aportación</th>
								<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Fin de stake</th>
								<th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
									<span class="sr-only">Ver</span>
								</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-200">

							@if (count($stake_usuarios) > 0)
								@foreach ($stake_usuarios as $stake)
									<tr>
										<td class="py-4 pr-3 pl-4 text-sm font-normal whitespace-nowrap text-gray-900 sm:pl-0">{{ $stake->stake->nombre }}</td>
										<td class="py-4 pr-3 pl-3 text-sm font-normal whitespace-nowrap text-gray-900">{{ number_format($stake->monto, 2, ',', '.') }}€</td>
										<td class="py-4 pr-3 pl-3 text-sm font-normal whitespace-nowrap text-gray-900">{{ Carbon\Carbon::parse($stake->fin)->diffForHumans() }}</td>
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
	</div>
@endsection

@section('modales')
	<div class="relative z-100 hidden" id="modal_stake" aria-labelledby="dialog-title" role="dialog" aria-modal="true">
		<div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
		<div class="fixed inset-0 z-10 w-screen overflow-y-auto">
			<div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">

				<div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
					<form id="aplicar_stake" action="">
						@csrf
						<div class="sm:flex sm:items-start">
							<div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
								<svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
									<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
								</svg>
							</div>
							<div class="mt-3 sm:mt-0 sm:ml-4 sm:text-left space-y-4">

								<!-- Alerta -->
								<div class="alerta hidden rounded-md bg-red-50 p-4">
									<div class="flex">
										<div class="shrink-0">
											<svg class="size-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
												<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
											</svg>
										</div>
										<div class="ml-3">
											<h3 class="text-sm font-medium text-red-800">Error</h3>
											<div class="mt-2 text-sm text-red-700">
												<div id="mensaje_alerta"></div>
												<ul id="lista_errores"></ul>
											</div>
										</div>
									</div>
								</div>

								<h3 class="text-base font-semibold text-gray-900" id="dialog-title">Aplicar a stake</h3>
								<div class="mt-2">
									<p class="text-sm text-gray-500">
										¿Estás seguro que quieres aplicar a este stake? Asegúrate antes de poder continuar. No podrás deshacer esta acción.
									</p>
								</div>

								<div class="mt-2 flex gap-1 flex-col">
									<label class="text-sm text-gray-900" for="input_monto">Selecciona tu cuenta</label>
									<div class="overflow-auto min-h-auto max-h-[200px]">
										<fieldset aria-label="Privacy setting" class="-space-y-px bg-white">
											@foreach ($cuentas as $cuenta)
												<label value="{{ $cuenta->numero_cuenta }}" aria-label="{{ $cuenta->numero_cuenta }}" aria-description="{{ $cuenta->nombre_cuenta }}" class="group flex cursor-pointer border border-gray-200 p-4 focus:outline-hidden has-checked:relative has-checked:border-indigo-200 has-checked:bg-indigo-50">
													<input name="cuenta" value="{{ $cuenta->numero_cuenta }}" type="radio"
														class="relative mt-0.5 size-4 shrink-0 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden">
													<span class="ml-3 flex flex-col">
														<span class="block text-sm font-medium text-gray-900 group-has-checked:text-indigo-900">{{ $cuenta->numero_cuenta }} ({{ number_format($cuenta->saldo, 2, ',', '.') }})€</span>
														<span class="block text-sm text-gray-500 group-has-checked:text-indigo-700">{{ $cuenta->nombre_cuenta }}</span>
													</span>
												</label>
											@endforeach
										</fieldset>
									</div>
								</div>

								<div class="mt-2 flex gap-1 flex-col pb-3">
									<label class="text-sm text-gray-900" for="input_monto">Introduce el monto</label>
									<input type="number" name="monto" class="p-2 text-sm ring ring-gray-300 rounded">
								</div>

								<div class="mt-2 flex gap-1 flex-col">
									<span class="text-xs text-red-500">Se retirará el dinero y se generará un movimiento en tu cuenta.</span>
									<input type="text" id="value_stake" hidden value="" name="stake">
								</div>
							</div>

						</div>
						<div class="mt-5 sm:mt-4 sm:ml-10 sm:flex sm:pl-4">
							<button type="submit" class="cursor-pointer inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:w-auto">Aplicar stake</button>
							<button type="button" id="cerrar_modal" class="cursor-pointer mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto">Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {

			$(document).on('click', '.abrir_modal', function() {
				let datos = $(this).attr('target'); // <-- .attr en vez de .prop
				$('#value_stake').val(datos); // .val() es más apropiado para inputs
				$('#modal_stake').removeClass('hidden');
			});

			$(document).on('click', '#cerrar_modal', function() {
				$('#value_stake').val(null); // .val() es más apropiado para inputs
				$('#modal_stake').addClass('hidden');
			});

			$('#aplicar_stake').on('submit', function(event) {
				event.preventDefault();

				// Llamar al formulario
				var formulario = $(this);

				// Serializa los parámetros
				let datos = new FormData(this);

				// Crea la petición
				$.ajax({
					type: "post",
					url: "{{ route('api.perfil.stake') }}",
					data: datos,
					contentType: false,
					processData: false,
					dataType: "json",
					beforeSend: function() {
						$(formulario).find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
					},
					success: function(response) {
						$('#modal_stake').addClass('hidden');
						window.location.reload();

						console.log(respones)
					},
					error: function(response) {
						// setear errores de validación
						let errores = response.responseJSON.errores;
						let mensaje = response.responseJSON.mensaje;

						if (errores) {
							let mensajeErrores = '<ul>';
							for (let campo in errores) {
								mensajeErrores += '<li>' + errores[campo].join('</li><li>') + '</li>';
							}
							mensajeErrores += '</ul>';
							$('.alerta').removeClass('hidden');
							$('#lista_errores').empty().append(mensajeErrores);
						}

						if (mensaje) {
							$('.alerta').removeClass('hidden');
							$('#mensaje_alerta').empty().append(mensaje)
						}

						// Desactivamos el botón
						$(formulario).find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
					}
				});
			})
		});
	</script>
@endsection
