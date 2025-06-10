@extends('1_plantilla.panel')

@section('contenido')
	<div class="space-y-8">

		<div class="border-l-4 border-yellow-400 bg-yellow-50 p-4">
			<div class="flex">
				<div class="shrink-0">
					<svg class="size-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
						<path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
					</svg>
				</div>
				<div class="ml-3">
					<p class="text-sm text-yellow-700">
						<strong>Atención</strong>. Asegúrate antes de enviar dinero, la operación no se puede deshacer.
					</p>
				</div>
			</div>
		</div>

		<div class="sm:flex sm:items-center">
			<div class="sm:flex-auto">
				<h1 class="text-base font-semibold text-gray-900">Centro de transferencias</h1>
				<p class="mt-2 text-sm text-gray-700">Envia dinero a tus cuentas o tus contactos</p>
			</div>
		</div>

		<div style="display: none" class="rounded-md alerta bg-red-50 p-4">
			<div class="flex">
				<div class="shrink-0">
					<svg class="size-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
						<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
					</svg>
				</div>
				<div class="ml-3">
					<h3 class="text-sm font-medium text-red-800">Ha ocurrido un error</h3>
					<div class="mt-2 text-sm text-red-700">
						<span id="mensaje"></span>
						<ul id="mensaje-lista" role="list" class="list-disc space-y-1 pl-5">

						</ul>
					</div>
				</div>
			</div>
		</div>

		<form id="enviar_dinero" action="" class="space-y-7" id="formulario_cargar">
			<div>
				<fieldset aria-label="Privacy setting" class="-space-y-px rounded-md bg-white">
					@foreach ($cuentas as $cuenta)
						<label value="{{ $cuenta->numero_cuenta }}" aria-label="{{ $cuenta->numero_cuenta }}" aria-description="{{ $cuenta->nombre_cuenta }}" class="group flex cursor-pointer border border-gray-200 p-4 first:rounded-tl-md first:rounded-tr-md last:rounded-br-md last:rounded-bl-md focus:outline-hidden has-checked:relative has-checked:border-indigo-200 has-checked:bg-indigo-50">
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

			<ul class="flex w-full gap-3 overflow-auto">
				<li>
					<input type="radio" id="precio-10" name="precio" value="10" class="hidden peer" required />
					<label for="precio-10" class="inline-flex items-center justify-center w-full p-2 px-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:hover:bgl-indigo-200/50 peer-checked:bg-indigo-200/50 peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-400">
						<div class="block text-center">
							<div class="w-full text-center">10€</div>
						</div>
					</label>
				</li>

				<li>
					<input type="radio" id="precio-20" name="precio" value="20" class="hidden peer" required />
					<label for="precio-20" class="inline-flex items-center justify-center w-full p-2 px-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:hover:bgl-indigo-200/50 peer-checked:bg-indigo-200/50 peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-400">
						<div class="block text-center">
							<div class="w-full text-center">20€</div>
						</div>
					</label>
				</li>

				<li>
					<input type="radio" id="precio-50" name="precio" value="50" class="hidden peer" required />
					<label for="precio-50" class="inline-flex items-center justify-center w-full p-2 px-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:hover:bgl-indigo-200/50 peer-checked:bg-indigo-200/50 peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-400">
						<div class="block text-center">
							<div class="w-full text-center">50€</div>
						</div>
					</label>
				</li>

				<li>
					<input type="radio" id="precio-100" name="precio" value="100" class="hidden peer" required />
					<label for="precio-100" class="inline-flex items-center justify-center w-full p-2 px-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:hover:bgl-indigo-200/50 peer-checked:bg-indigo-200/50 peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-400">
						<div class="block text-center">
							<div class="w-full text-center">100€</div>
						</div>
					</label>
				</li>

				<li>
					<input type="radio" id="precio-another" name="precio" value="" class="hidden peer" required />
					<label for="precio-another" class="inline-flex items-center justify-center w-full p-2 px-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:hover:bgl-indigo-200/50 peer-checked:bg-indigo-200/50 peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-400">
						<div class="block text-center">
							<div class="w-full text-center">Otro</div>
						</div>
					</label>
				</li>
			</ul>

			<div id="custom-precio-container" class="mt-4 hidden">
				<label for="custom-precio" class="block text-sm font-medium text-gray-700">Introduce la cantidad</label>
				<input type="number" id="custom-precio" name="custom-precio" class="p-2 mt-1 block w-full rounded-md border-gray-300 ring ring-gray-200 focus:border-indigo-500 focus:ring-indigo-500 sm:text-md" placeholder="0,00">
			</div>


			<script>
				document.addEventListener('DOMContentLoaded', function() {
					const precioAnotherRadio = document.getElementById('precio-another');
					const customprecioContainer = document.getElementById('custom-precio-container');

					precioAnotherRadio.addEventListener('change', function() {
						if (precioAnotherRadio.checked) {
							customprecioContainer.classList.remove('hidden');
						}
					});

					const otherRadios = document.querySelectorAll('input[name="precio"]:not(#precio-another)');
					otherRadios.forEach(radio => {
						radio.addEventListener('change', function() {
							customprecioContainer.classList.add('hidden');
						});
					});
				});
			</script>

			<div id="numero_cuenta_entrante" class="mt-4">
				<label for="cuenta_entrante" class="block text-sm font-medium text-gray-700">Número de cuenta ANB</label>
				<input type="text" id="cuenta_entrante" name="cuenta_entrante" class="p-2 mt-1 block w-full rounded-md border-gray-300 ring ring-gray-200 focus:border-indigo-500 focus:ring-indigo-500 sm:text-md" placeholder="">
			</div>

			<div class="relative">
				<div class="absolute inset-0 flex items-center" aria-hidden="true">
					<div class="w-full border-t border-gray-300"></div>
				</div>
				<div class="relative flex justify-center">
					<span class="bg-white px-2 text-sm text-gray-500">O retirar a una wallet</span>
				</div>
			</div>


			<div id="direccion-externa" class="mt-4">
				<label for="wallet_externa" class="block text-sm font-medium text-gray-700">Dirección wallet (Retirada externa)</label>
				<input type="text" id="wallet_externa" name="wallet_externa" class="p-2 mt-1 block w-full rounded-md border-gray-300 ring ring-gray-200 focus:border-indigo-500 focus:ring-indigo-500 sm:text-md" placeholder="">
			</div>

			<div class="campo">
				<button type="submit" class="cursor-pointer rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continuar</button>
			</div>
		</form>
	</div>
@endsection

@section('modales')
	<div>
		<div class="modal hidden relative z-100" aria-labelledby="dialog-title" role="dialog" aria-modal="true">

			<div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

			<div class="fixed inset-0 z-10 w-screen overflow-y-auto">
				<div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

					<div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
						<div>
							<div class="flex size-12 items-center justify-center rounded-full bg-green-100">
								<svg class="size-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
									<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
								</svg>
							</div>
							<div class="mt-3 text-left sm:mt-5">
								<h3 class="text-base font-semibold text-gray-900" id="dialog-title">La transferencia se ha realizado con éxito</h3>
								<div class="mt-2">
									<p class="text-sm text-gray-500">Te adjuntamos la información correspondiente de la transferencia:</p>
								</div>

								<div id="pool" class="mt-5 space-y-5">

									<div class="campo">
										<div class="text-gray-500 text-xs font-semibold">
											Cuenta saliente:
										</div>
										<div class="campo">
											<span id="target1"></span>
										</div>
									</div>

									<div class="campo">
										<div class="text-gray-500 text-xs font-semibold">
											Wallet destino:
										</div>
										<div class="campo">
											<span id="target2"></span>
										</div>
									</div>

									<div class="campo">
										<div class="text-gray-500 text-xs font-semibold">
											Interés aplicado en el envío
										</div>
										<div class="campo">
											<span id="target3"></span>
										</div>
									</div>

								</div>
							</div>
						</div>
						<div class="mt-5 sm:mt-6">
							<a href="{{ route('panel_cuentas') }}">
								<button type="button" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Entendido</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {

			$('#enviar_dinero').on('submit', function(event) {
				event.preventDefault();

				// Llamar al formulario
				var formulario = $(this);

				// Serializa los parámetros
				let datos = new FormData(this);

				// Crea la petición
				$.ajax({
					type: "post",
					url: "{{ route('api.perfil.transferencia') }}",
					data: datos,
					contentType: false,
					processData: false,
					dataType: "json",
					beforeSend: function() {
						$('.alerta').fadeOut(0)

						$(formulario).find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
					},
					success: function(response) {
						console.log(response)

						if (response.modal) {
							$('.modal').removeClass('hidden');
							$('#target1').text(response.modal_data.cuenta_saliente)
							$('#target2').text(response.modal_data.address_to)
							$('#target3').text(response.modal_data.interes)
						} else {
							window.location.reload();
						}

					},
					error: function(response) {
						// setear errores de validación
						let errores = response.responseJSON.errores;
						let mensaje = response.responseJSON.mensaje;

						if (errores) {
							$('.alerta').fadeIn(200)
							$('#mensaje-lista').empty().append(errores.message)
							for (let campo in errores) {
								if (errores.hasOwnProperty(campo)) {
									errores[campo].forEach(msg => {
										$('#mensaje-lista').append(`<li>${msg}</li>`);
									});
								}
							}
						}

						// if (mensaje) {
						// 	$('.alerta').fadeIn(200)
						// 	$('#mensaje').empty().append(`<li>${mensaje}</li>`);
						// }

						// Desactivamos el botón
						$(formulario).find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
					}
				});
			})
		});
	</script>
@endsection
