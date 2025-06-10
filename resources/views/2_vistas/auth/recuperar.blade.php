@extends('1_plantilla.auth')

@section('contenido')
	<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
		<div class="sm:mx-auto sm:w-full sm:max-w-sm">
			<img class="mx-auto h-10 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
			<h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Recuperar cuenta</h2>
		</div>

		<div class="mt-10 lg:max-w-sm sm:mx-auto sm:w-full sm:max-w-sm">
			<!-- Alerta -->
			<div class="alerta hidden rounded-md bg-red-50 p-4 mb-8">
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

			<form id="recuperar" class="gap-6 grid grid-cols-2" action="#" method="POST">
				@csrf
				<!-- Campo -->
				<div class="col-span-2">
					<label for="nombre_usuario" class="block text-sm/6 font-medium text-gray-900">Nombre de usuario</label>
					<div class="mt-2">
						<input type="text" name="nombre_usuario" id="nombre_usuario" autocomplete="nombre_usuario" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
					</div>
				</div>

				<!-- Campo -->
				<div class="col-span-2">
					<label for="correo" class="block text-sm/6 font-medium text-gray-900">Correo electrónico</label>
					<div class="mt-2">
						<input type="text" name="correo" id="correo" autocomplete="correo" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
					</div>
				</div>

				<!-- Enviar -->
				<div class="col-span-2 mt-6">
					<button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Enviar</button>
				</div>

			</form>

			<p class="mt-10 text-center text-sm/6 text-gray-500">
				¿Te acordaste?
				<a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Iniciar sesión</a>
			</p>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {

			$('#recuperar').on('submit', function(event) {
				event.preventDefault();

				// Llamar al formulario
				var formulario = $(this);

				// Serializa los parámetros
				let datos = new FormData(this);

				// Crea la petición
				$.ajax({
					type: "post",
					url: "{{ route('api_recuperar') }}",
					data: datos,
					contentType: false,
					processData: false,
					dataType: "json",
					beforeSend: function() {
						$(formulario).find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
					},
					success: function(response) {
						alert('enviado');
						window.location.reload();
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
