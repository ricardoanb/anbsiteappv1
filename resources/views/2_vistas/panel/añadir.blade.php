@extends('1_plantilla.panel')

@section('contenido')
	<div class="space-y-8">
		<div class="sm:flex sm:items-center">
			<div class="sm:flex-auto">
				<h1 class="text-base font-semibold text-gray-900">Añadir recursos</h1>
				<p class="mt-2 text-sm text-gray-700">Añade dinero a tus cuentas de manera rápida</p>
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
						<ul id="mensaje-lista" role="list" class="list-disc space-y-1 pl-5">

						</ul>
					</div>
				</div>
			</div>
		</div>

		<form id="añadir_dinero" action="" class="space-y-7" id="formulario_cargar">
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

			<div class="campo">
				<button type="submit" class="cursor-pointer rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continuar</button>
			</div>
		</form>

	</div>
@endsection

@section('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {

			$('#añadir_dinero').on('submit', function(event) {
				event.preventDefault();

				// Llamar al formulario
				var formulario = $(this);

				// Serializa los parámetros
				let datos = new FormData(this);
				datos.append('usuario', "{{ auth('api')->user()->uuid }}")

				// Crea la petición
				$.ajax({
					type: "post",
					url: "{{ route('api.payment.dinamico') }}",
					data: datos,
					contentType: false,
					processData: false,
					dataType: "json",
					beforeSend: function() {
						$(formulario).find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
					},
					success: function(response) {
						console.log(response)
						let ventanaCheckout = window.open("", "_blank", "width=600,height=800");

						// Ahora sí, redirige dentro de la ventana ya abierta
						ventanaCheckout.location.href = response.checkout_url;

						// Escuchar mensajes del postMessage
						window.addEventListener("message", function(event) {
							if (event.data === "pago_exitoso") {
								location.reload();
							}
						});

						// // Vigilar si la ventana se cierra
						let watcher = setInterval(function() {
							if (ventanaCheckout && ventanaCheckout.closed) {
								clearInterval(watcher);
								$(formulario).find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
							}
						}, 500);
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

						if (mensaje) {
							$('.alerta').fadeIn(200)
							$('#mensaje-lista').empty().append(`<li>${mensaje}</li>`);
						}

						// Desactivamos el botón
						$(formulario).find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
					}
				});
			})
		});
	</script>
@endsection
