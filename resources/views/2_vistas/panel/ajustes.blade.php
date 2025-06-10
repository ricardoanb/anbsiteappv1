@extends('1_plantilla.panel')

@section('contenido')
	<!-- Sección -->
	<div class="mx-auto max-w-2xl space-y-16 sm:space-y-10 lg:mx-0 lg:max-w-none">
		<form id="form_perfil" action="">
			@csrf
			<div>
				<h2 class="text-base/7 font-semibold text-gray-900">Perfil</h2>
				<p class="mt-1 text-sm/6 text-gray-500">Esta es tu información de contacto</p>

				<dl class="mt-6 divide-y divide-gray-100 border-t border-gray-200 text-sm/6">
					<div class="py-6 sm:flex">
						<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Nombre</dt>
						<dd class="mt-1 flex items-center justify-start gap-x-6 sm:mt-0 sm:flex-auto">
							<input type="text" value="{{ Auth::user()->nombre }}" name="nombre" class="p-1 px-2 rounded lg:max-w-md w-full ring ring-gray-200">
						</dd>
					</div>
					<div class="py-6 sm:flex">
						<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Primer apellido</dt>
						<dd class="mt-1 flex items-center justify-start gap-x-6 sm:mt-0 sm:flex-auto">
							<input type="text" value="{{ Auth::user()->apellido_1 }}" name="apellido_1" class="p-1 px-2 rounded lg:max-w-md w-full ring ring-gray-200">
						</dd>
					</div>
					<div class="py-6 sm:flex">
						<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Segundo apellido</dt>
						<dd class="mt-1 flex items-center justify-start gap-x-6 sm:mt-0 sm:flex-auto">
							<input type="text" value="{{ Auth::user()->apellido_2 }}" name="apellido_2" class="p-1 px-2 rounded lg:max-w-md w-full ring ring-gray-200">
						</dd>
					</div>
					<div class="py-6 sm:flex">
						<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Correo electrónico</dt>
						<dd class="mt-1 flex items-center justify-start gap-x-6 sm:mt-0 sm:flex-auto">
							<input type="text" name="correo" placeholder="{{ Auth::user()->correo }}" class="p-1 px-2 rounded lg:max-w-md w-full ring ring-gray-200">
						</dd>
					</div>
					<div class="py-6 sm:flex">
						<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Nombre de usuario</dt>
						<dd class="mt-1 flex items-center justify-start gap-x-6 sm:mt-0 sm:flex-auto">
							<input type="text" placeholder="{{ Auth::user()->nombre_usuario }}" name="nombre_usuario" class="p-1 px-2 rounded lg:max-w-md w-full ring ring-gray-200">
						</dd>
					</div>

					<div class="py-6 sm:flex">
						<dd class="mt-1 flex items-center justify-start gap-x-6 sm:mt-0 sm:flex-auto">
							<button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Actualizar</button>
						</dd>
					</div>
				</dl>
			</div>
		</form>

		<form id="form_password" enctype="multipart/form-data" action="">
			@csrf
			<div>
				<h2 class="text-base/7 font-semibold text-gray-900">Cambiar contraseña</h2>
				<p class="mt-1 text-sm/6 text-gray-500">Cambia tu contraseña diréctamente</p>

				<ul role="list" class="mt-6 divide-y divide-gray-100 border-t border-gray-200 text-sm/6">
					<li class="flex items-center justify-between gap-x-6 py-3 w-full">
						<div class="py-4 space-y-3 w-full">
							<dt class="font-medium text-gray-900 sm:flex-none sm:pr-6">Contraseña actual</dt>
							<dd class="mt-1 flex flex-1 items-center justify-between gap-x-6 sm:mt-0 sm:flex-auto">
								<input type="password" value="" name="password_actual" class="flex-1 p-1 px-2 rounded lg:max-w-md w-full ring ring-gray-200">
							</dd>
						</div>
					</li>
					<li class="flex items-center justify-between gap-x-6 py-3 w-full">
						<div class="py-4 space-y-3 w-full">
							<dt class="font-medium text-gray-900 sm:flex-none sm:pr-6">Contraseña nueva</dt>
							<dd class="mt-1 flex flex-1 items-center justify-between gap-x-6 sm:mt-0 sm:flex-auto">
								<input type="password" value="" name="password_nueva" class="flex-1 p-1 px-2 rounded lg:max-w-md w-full ring ring-gray-200">
							</dd>
						</div>
					</li>
					<li class="flex items-center justify-between gap-x-6 py-3 w-full">
						<div class="py-4 space-y-3 w-full">
							<dt class="font-medium text-gray-900 sm:flex-none sm:pr-6">Repite contraseña nueva</dt>
							<dd class="mt-1 flex flex-1 items-center justify-between gap-x-6 sm:mt-0 sm:flex-auto">
								<input type="password" value="" name="password_nueva_confirmation" class="flex-1 p-1 px-2 rounded lg:max-w-md w-full ring ring-gray-200">
							</dd>
						</div>
					</li>
				</ul>

				<div class="flex border-t border-gray-100 pt-6">
					<button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Actualizar</button>
				</div>
			</div>
		</form>
	</div>

	<!-- NOTIFICACION -->
	<div id="notificacion" class="z-100 pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6 hidden" aria-live="assertive">
		<div class="flex w-full flex-col items-center space-y-4 sm:items-end">
			<!-- Notification panel -->
			<div id="notificacion-panel" class="transition transform ease-out duration-300 translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2 pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black/5">
				<div class="p-4">
					<div class="flex items-start">
						<div class="shrink-0">
							<svg class="size-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
							</svg>
						</div>
						<div class="ml-3 w-0 flex-1 pt-0.5">
							<p id="notificacion-titulo" class="text-sm font-medium text-gray-900">¡Guardado!</p>
							<p id="notificacion-mensaje" class="mt-1 text-sm text-gray-500">Los cambios se han guardado correctamente.</p>
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
			$('#form_perfil').on('submit', function(event) {
				event.preventDefault();

				// Llamar al formulario
				var formulario = $(this);

				// Serializa los parámetros
				let datos = new FormData(this);
				datos.append('_method', 'PUT');

				// Crea la petición
				$.ajax({
					type: "post",
					url: "{{ route('api_perfil_perfil') }}",
					data: datos,
					contentType: false,
					processData: false,
					xhrFields: {
						withCredentials: true
					},
					dataType: "json",
					beforeSend: function() {
						formulario.find('input, select, textarea').removeClass('ring-red-500').add('ring-gray-200');
						$('.pqmsg').remove();
						$(formulario).find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
					},
					success: function(response) {
						mostrarNotificacion("¡Perfil actualizado!", "Los datos fueron guardados correctamente.");
						$(formulario).find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
					},
					error: function(response) {
						const errores = response.responseJSON?.errores || {};
						const mensaje = response.responseJSON?.mensaje || response.responseJSON?.message || 'Error al procesar la solicitud.';

						// Limpiar errores anteriores SOLO dentro del formulario actual
						formulario.find('input, select, textarea').removeClass('ring-red-500');
						formulario.find('.error-text').remove();

						// Mostrar errores por campo
						Object.entries(errores).forEach(([campo, mensajes]) => {
							const input = formulario.find(`[name="${campo}"]`);
							input.addClass('ring-red-500');

							// Si no hay <p> de error, lo insertamos justo debajo
							if (!input.next('.error-text').length) {
								input.after(`<p class="pqmsg mt-1 text-sm text-red-600 error-text">${mensajes[0]}</p>`);
							}
						});

						// Reactivar botón
						formulario.find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
					}
				});
			});

			$('#form_password').on('submit', function(event) {
				event.preventDefault();

				// Llamar al formulario
				var formulario2 = $(this);

				// Serializa los parámetros
				let datos = new FormData(this);
				datos.append('_method', 'PUT');

				// Crea la petición
				$.ajax({
					type: "post",
					url: "{{ route('api_perfil_password') }}",
					data: datos,
					contentType: false,
					processData: false,
					xhrFields: {
						withCredentials: true // 🔑 ESTA LÍNEA ENVÍA LA COOKIE JWT
					},
					dataType: "json",
					beforeSend: function() {
						$(formulario2).find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
					},
					success: function(response) {
						mostrarNotificacion("¡Contraseña cambiada!", "Los datos fueron guardados correctamente.");
						$(formulario).find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);

						window.location.reload();
					},
					error: function(response) {
						const errores = response.responseJSON?.errores || {};
						const mensaje = response.responseJSON?.mensaje || response.responseJSON?.message || 'Error al procesar la solicitud.';

						// Limpiar errores anteriores SOLO dentro del formulario2 actual
						formulario2.find('input, select, textarea').removeClass('ring-red-500');
						formulario2.find('.error-text').remove();

						// Mostrar errores por campo
						Object.entries(errores).forEach(([campo, mensajes]) => {
							const input = formulario2.find(`[name="${campo}"]`);
							input.addClass('ring-red-500');

							// Si no hay <p> de error, lo insertamos justo debajo
							if (!input.next('.error-text').length) {
								input.after(`<p class="pqmsg mt-1 text-sm text-red-600 error-text">${mensajes[0]}</p>`);
							}
						});

						// Reactivar botón
						formulario2.find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
					}
				});
			});

			function mostrarNotificacion(titulo = '¡Hecho!', mensaje = 'Cambios guardados correctamente.') {
				const noti = $('#notificacion');
				const panel = $('#notificacion-panel');

				// Setea el contenido
				$('#notificacion-titulo').text(titulo);
				$('#notificacion-mensaje').text(mensaje);

				// Muestra el contenedor
				noti.removeClass('hidden');

				// Aplica animación de entrada
				panel.removeClass('translate-y-2 opacity-0 sm:translate-x-2');
				panel.addClass('translate-y-0 opacity-100 sm:translate-x-0');

				// Oculta después de 3 segundos
				setTimeout(() => cerrarNotificacion(), 3000);
			}

			function cerrarNotificacion() {
				const noti = $('#notificacion');
				const panel = $('#notificacion-panel');

				panel.removeClass('translate-y-0 opacity-100 sm:translate-x-0');
				panel.addClass('opacity-0');

				setTimeout(() => {
					noti.addClass('hidden');
					panel.removeClass('opacity-0').addClass('translate-y-2 opacity-0 sm:translate-x-2');
				}, 200); // Tiempo acorde a Tailwind: ease-in duration-100
			}

			// Cierre manual
			$('#notificacion-cerrar').on('click', cerrarNotificacion);
		});
	</script>
@endsection
