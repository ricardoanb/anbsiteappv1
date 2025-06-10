@extends('1_plantilla.auth')

@section('contenido')
	<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
		<div class="step">
			<div class="sm:mx-auto sm:w-full sm:max-w-sm">
				<img class="mx-auto h-10 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
				<h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Regístrate</h2>
			</div>

			<div class="mt-10 lg:max-w-sm sm:mx-auto sm:w-full sm:max-w-sm">
				<form id="registro" class="gap-6 grid grid-cols-2" action="#" method="POST">
					@csrf
					<!-- Campo -->
					<div class="col-span-2">
						<label for="nombre" class="block text-sm/6 font-medium text-gray-900">Nombre</label>
						<div class="mt-2">
							<input type="text" name="nombre" id="nombre" autocomplete="nombre" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
						</div>
					</div>

					<!-- Campo -->
					<div class="col-span-1">
						<label for="apellido_1" class="block text-sm/6 font-medium text-gray-900">Primer apellido</label>
						<div class="mt-2">
							<input type="text" name="apellido_1" id="apellido_1" autocomplete="apellido_1" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
						</div>
					</div>

					<!-- Campo -->
					<div class="col-span-1">
						<label for="apellido_2" class="block text-sm/6 font-medium text-gray-900">Segundo apellido</label>
						<div class="mt-2">
							<input type="text" name="apellido_2" id="apellido_2" autocomplete="apellido_2" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
						</div>
					</div>

					<!-- Campo -->
					<div class="col-span-2">
						<label for="nombre_usuario" class="block text-sm/6 font-medium text-gray-900">Nombre de usuario</label>
						<div class="mt-2">
							<input type="text" name="nombre_usuario" id="nombre_usuario" autocomplete="nombre_usuario" placeholder="Ej: ricardo123" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
						</div>
					</div>

					<!-- Campo -->
					<div class="col-span-2">
						<label for="correo" class="block text-sm/6 font-medium text-gray-900">Correo electrónico</label>
						<div class="mt-2">
							<input type="email" name="correo" id="correo" autocomplete="correo" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
						</div>
					</div>

					<!-- Campo -->
					<div class="col-span-2">
						<div class="flex items-center justify-between">
							<label for="password" class="block text-sm/6 font-medium text-gray-900">Contraseña</label>
						</div>
						<div class="mt-2">
							<input type="password" name="password" id="password" autocomplete="current-password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
						</div>
					</div>

					<!-- Enviar -->
					<div class="col-span-2 mt-6">
						<button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Registrarse</button>
					</div>
				</form>

				<p class="mt-10 text-center text-sm/6 text-gray-500">
					¿Ya eres miembro?
					<a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Iniciar sesión</a>
				</p>
			</div>
		</div>

		<div class="confirmacion" style="display: none">
			<div class=" max-w-sm mx-auto">
				<div class="rounded-md bg-green-50 p-4">
					<div class="flex">
						<div class="shrink-0">
							<svg class="size-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
								<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
							</svg>
						</div>
						<div class="ml-3">
							<p class="text-sm font-medium text-green-800">
								Cuenta registrada.
								<a class="text-indigo-500 hover:text-indigo:600" href="{{ route('login') }}">
									Ya puedes iniciar sesión
								</a>
							</p>
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

			$('#registro').on('submit', function(event) {
				event.preventDefault();

				// Llamar al formulario
				var formulario = $(this);

				// Serializa los parámetros
				let datos = new FormData(this);

				// Crea la petición
				$.ajax({
					type: "post",
					url: "{{ route('api_registro') }}",
					data: datos,
					contentType: false,
					processData: false,
					dataType: "json",
					beforeSend: function() {
						$(formulario).find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
					},
					success: function(response) {
						$('.step').fadeOut(300, function() {
							$('.step').empty();

							$('.confirmacion').fadeIn(300)
						})
					},
					error: function(response) {
						console.log(response);

						// setear errores de validación
						let errores = response.responseJSON.errores;

						if (errores) {
							// Limpiar mensajes de error previos
							formulario.find('.text-red-500').remove();
							formulario.find('.border-red-500').removeClass('border-red-500');

							Object.keys(errores).forEach(function(key) {
								let input = formulario.find(`[name="${key}"]`);
								if (input.length) {
									input.addClass('border-red-500');
									let errorMessage = `<p class="text-red-500 text-sm mt-1">${errores[key][0]}</p>`;
									input.after(errorMessage);
								}
							});
						}

						// Desactivamos el botón
						$(formulario).find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
					}
				});
			})
		});
	</script>
@endsection
