@extends('1_plantilla.auth')

@section('contenido')
	<div class="flex min-h-full items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
		<div class="w-full max-w-sm space-y-10">
			<div>
				<img class="mx-auto h-10 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
				<h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Inicia sesión a tu cuenta</h2>
			</div>
			<form class="space-y-6" id="login" action="">
				@csrf
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
								<span id="mensaje_alerta"></span>
							</div>
						</div>
					</div>
				</div>

				<div>
					<div class="col-span-2">
						<input id="correo" name="correo" type="email" autocomplete="correo" aria-label="Email address" class="block w-full rounded-t-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:relative focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Correo electrónico">
					</div>
					<div class="-mt-px">
						<input id="password" name="password" type="password" autocomplete="current-password" aria-label="Password" class="block w-full rounded-b-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:relative focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Contraseña">
					</div>
				</div>

				<div class="flex items-center justify-between">
					<div class="flex gap-3">
						<div class="flex h-6 shrink-0 items-center">
							<div class="group grid size-4 grid-cols-1">
								<input id="remember-me" name="remember-me" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
								<svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
									<path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
									<path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</div>
						</div>
						<label for="remember-me" class="block text-sm/6 text-gray-900">Recuérdame</label>
					</div>

					<div class="text-sm/6">
						<a href="{{ route('recuperar') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">¿Olvidó la contraseña?</a>
					</div>
				</div>

				<div>
					<button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Iniciar sesión</button>
				</div>
			</form>

			<p class="text-center text-sm/6 text-gray-500">
				¿No eres miembro?
				<a href="{{ route('registro') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Regístrate ahora</a>
			</p>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {

			$('#login').on('submit', function(event) {
				event.preventDefault();

				// Llamar al formulario
				var formulario = $(this);

				// Serializa los parámetros
				let datos = new FormData(this);

				// Crea la petición
				$.ajax({
					type: "post",
					url: "{{ route('api_login') }}",
					data: datos,
					contentType: false,
					processData: false,
					dataType: "json",
					beforeSend: function() {
						$(formulario).find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
					},
					success: function(response) {
						$('html').fadeOut(300, function() {
							window.location.href = '{{ route('panel_inicio') }}';
						});
						console.log(respones)
					},
					error: function(response) {
						// setear errores de validación
						let errores = response.responseJSON;
						let mensaje = response.responseJSON.mensaje;

						if (errores.errors) {
							$('.alerta').removeClass('hidden');
							$('#mensaje_alerta').empty().append(errores.message)
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
