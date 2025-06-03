@extends('1_plantillas.panel')

@section('contenido')
	<!-- Global notification live region, render this permanently at the end of the document -->
	<div id="master_notificacion" aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6 hidden">
		<div class="flex w-full flex-col items-center space-y-4 sm:items-end">
			<div id="window_notificacion" class="transform pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black/5 translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2">
				<div class="p-4">
					<div class="flex items-start">
						<div class="shrink-0">
							<svg class="size-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
							</svg>
						</div>
						<div class="ml-3 w-0 flex-1 pt-0.5">
							<p class="text-sm font-medium text-gray-900">Cambios realizados</p>
							<p class="mt-1 text-sm text-gray-500">Los cambios se han guardado.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="space-y-15">
		<div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 pb-16 md:grid-cols-3">
			<div>
				<h2 class="text-base/7 font-semibold">Información personal</h2>
				<p class="mt-1 text-sm/6">Toda tu información personal para contacto y funcionamiento.</p>
			</div>

			<form id="formu_personal" enctype="multipart/form-data" class="md:col-span-2">
				@csrf
				<div class="alerta hidden rounded-md bg-red-50 p-4 mb-10">
					<div class="flex">
						<div class="shrink-0">
							<svg class="size-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
								<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
							</svg>
						</div>
						<div class="ml-3">
							<h3 class="text-sm font-medium text-red-800">Ha ocurrido un error</h3>
							<div class="msg-alerta mt-2 text-sm text-red-700">

							</div>
						</div>
					</div>
				</div>

				<div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-5">
					<div class="col-span-full flex items-center gap-x-8">
						<img id="avatarPreview" src="{{ Auth::user()->avatar ? Auth::user()->avatar : 'URL_DE_AVATAR_POR_DEFECTO' }}" alt="Vista previa del avatar" class="size-20 flex-none rounded-full ring ring-gray-300 bg-white p-1 object-cover">
						<div>
							<button type="button" id="uploadAvatarButton" class="rounded-md bg-indigo-500 text-white px-3 py-2 text-sm font-semibold shadow-xs hover:bg-indigo-600 text-white">Subir avatar</button>
							<p class="mt-2 text-xs/5">JPG, GIF or PNG. 1MB max.</p>
						</div>
						<input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/png, image/jpeg, image/gif, image/jpg">
					</div>

					<!-- Subida de icono -->
					<script>
						$(document).ready(function() {
							const avatarPreview = $('#avatarPreview');
							const avatarInput = $('#avatarInput');
							const uploadAvatarButton = $('#uploadAvatarButton');

							$('#uploadAvatarButton').on('click', function() {
								$('#avatarInput').click();
							});

							$('#avatarInput').on('change', function() {
								const file = this.files[0]; // Obtiene el primer archivo seleccionado

								if (file) {
									const reader = new FileReader();

									reader.onload = function(e) {
										avatarPreview.attr('src', e.target.result); // Establece la URL de la vista previa a los datos del archivo leído
									}

									reader.readAsDataURL(file); // Lee el archivo como una URL de datos (base64)
								} else {
									// Si no se selecciona ningún archivo, restaura la imagen y el texto del botón
									avatarPreview.attr('src', "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80");
									uploadAvatarButton.text('Subir avatar');
								}
							});
						});
					</script>

					<div class="sm:col-span-4">
						<label for="nombre" class="block text-sm/6 font-medium">Nombre</label>
						<div class="mt-2">
							<input value="{{ Auth::user()->nombre }}" type="text" name="nombre" id="nombre" autocomplete="given-name" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-gray-300/50 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
						</div>
					</div>

					<div class="sm:col-span-2">
						<label for="apellido_1" class="block text-sm/6 font-medium">Primer apellido</label>
						<div class="mt-2">
							<input value="{{ Auth::user()->apellido_1 }}" type="text" name="apellido_1" id="apellido_1" autocomplete="family-name" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-gray-300/50 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
						</div>
					</div>

					<div class="sm:col-span-2">
						<label for="apellido_2" class="block text-sm/6 font-medium">Segundo apellido</label>
						<div class="mt-2">
							<input value="{{ Auth::user()->apellido_2 }}" type="text" name="apellido_2" id="apellido_2" autocomplete="family-name" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-gray-300/50 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
						</div>
					</div>

					<div class="col-span-full">
						<label for="correo" class="block text-sm/6 font-medium">Correo electrónico</label>
						<div class="mt-2">
							<input placeholder="{{ Auth::user()->correo }}" id="correo" name="correo" type="email" autocomplete="email" class="text-gray-900 block w-full rounded-md px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-gray-300/50 placeholder:text-gray-900 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
						</div>
					</div>

					<div class="col-span-full">
						<label for="nombre_usuario" class="block text-sm/6 font-medium">Nombre de usuario</label>
						<div class="mt-2">
							<div class="flex items-center rounded-md pl-3 outline-1 -outline-offset-1 outline-gray-300/50 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
								<div class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6">@</div>
								<input placeholder="{{ Auth::user()->nombre_usuario }}" type="text" name="nombre_usuario" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base placeholder:text-gray-900 focus:outline-none sm:text-sm/6">
							</div>
						</div>
					</div>
				</div>

				<div class="mt-8 flex">
					<button type="submit" class="text-white rounded-md bg-indigo-500 text-white px-3 py-2 text-sm font-semibold shadow-xs hover:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Guardar</button>
				</div>
			</form>
		</div>

		<div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
			<div>
				<h2 class="text-base/7 font-semibold">Cambiar contraseña</h2>
				<p class="mt-1 text-sm/6">Actualiza la contraseña de tu cuenta.</p>
			</div>

			<form id="formu_passwords" class="md:col-span-2">
				@csrf
				<div class="alerta hidden rounded-md bg-red-50 p-4 mb-10">
					<div class="flex">
						<div class="shrink-0">
							<svg class="size-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
								<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
							</svg>
						</div>
						<div class="ml-3">
							<h3 class="text-sm font-medium text-red-800">Ha ocurrido un error</h3>
							<div class="msg-alerta mt-2 text-sm text-red-700">

							</div>
						</div>
					</div>
				</div>

				<div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
					<div class="col-span-full">
						<label for="current-password" class="block text-sm/6 font-medium">Contraseña actual</label>
						<div class="mt-2">
							<input id="current-password" name="current_password" type="password" autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-gray-300/50 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
						</div>
					</div>

					<div class="col-span-full">
						<label for="new-password" class="block text-sm/6 font-medium">Nueva contraseña</label>
						<div class="mt-2">
							<input id="new-password" name="password" type="password" autocomplete="new-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-gray-300/50 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
						</div>
					</div>

					<div class="col-span-full">
						<label for="password_confirmation" class="block text-sm/6 font-medium">Confirmar contraseña</label>
						<div class="mt-2">
							<input id="password_confirmation" name="password_confirmation" type="password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base outline-1 -outline-offset-1 outline-gray-300/50 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
						</div>
					</div>
				</div>

				<div class="mt-8 flex">
					<button type="submit" class="rounded-md bg-indigo-500 text-white px-3 py-2 text-sm font-semibold shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Guardar</button>
				</div>
			</form>
		</div>

		<div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
			<div>
				<h2 class="text-base/7 font-semibold">Eliminar cuenta</h2>
				<p class="mt-1 text-sm/6">
					¿Quieres desistir de tu cuenta? Todos tus datos se eliminarán y para acceder deberás crear una cuenta nueva.
				</p>
			</div>

			<form class="flex items-start md:col-span-2">
				<button type="submit" class="text-white rounded-md bg-red-500 px-3 py-2 text-sm font-semibold shadow-xs hover:bg-red-400">Eliminar mi cuenta</button>
			</form>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		const masterNotificacion = $('#master_notificacion');
		const windowNotificacion = $('#window_notificacion');
		const animationClasses = 'transform ease-out duration-300 translate-y-0 opacity-100 sm:translate-x-0 transition ease-in duration-100';
		const hiddenClasses = 'translate-y-2 opacity-0 sm:translate-y-0';
	</script>

	<script>
		$('#formu_personal').on('submit', function(event) {
			event.preventDefault();
			let data = new FormData(this);

			$.ajax({
				type: "post",
				url: "{{ route('api.usuario.actualizar') }}",
				data: data,
				processData: false,
				contentType: false,
				dataType: "json",
				success: function(response) {
					masterNotificacion.removeClass('hidden');
					windowNotificacion.removeClass(hiddenClasses).addClass(animationClasses);
					$('#formu_personal button').removeClass('opacity-50 cursor-not-allowed').attr('disabled', false);

					// Ocultar la notificación después de un tiempo
					setTimeout(() => {
						windowNotificacion.removeClass(animationClasses).addClass(hiddenClasses);
						setTimeout(() => {
							masterNotificacion.addClass('hidden');
						}, 300); // Espera la duración de la transición de salida
					}, 3000);
				},
				beforeSend: function() {
					$('#formu_personal button').addClass('opacity-50 cursor-not-allowed').attr('disabled', true);
				},
				error: function(res) {
					$('#formu_personal .alerta').removeClass('hidden');
					$('#formu_personal button').removeClass('opacity-50 cursor-not-allowed').attr('disabled', false);
					$('#formu_personal .msg-alerta').empty();
					if (res.responseJSON.msg) {
						$('#formu_personal .msg-alerta').append(`<li>
								` + res.responseJSON.msg + `
								</li>`)
					}
					if (res.responseJSON.errors) {
						$.each(res.responseJSON.errors, function(key, value) {
							$('#formu_personal .msg-alerta').append(`<li>
								` + value + `
								</li>`)
							$('#' + key).removeClass('outline-gray-300');
							$('#' + key).addClass('outline-red-500 focus:border-red-500 focus:outline-red-500');
						});
					}

				}
			});
		});
	</script>

	<script>
		$('#formu_passwords').on('submit', function(event) {
			event.preventDefault();
			let data = new FormData(this);

			$.ajax({
				type: "post",
				url: "{{ route('api.usuario.actualizar.pass') }}",
				data: data,
				processData: false,
				contentType: false,
				dataType: "json",
				success: function(response) {
					masterNotificacion.removeClass('hidden');
					windowNotificacion.removeClass(hiddenClasses).addClass(animationClasses);
					$('#formu_passwords button').removeClass('opacity-50 cursor-not-allowed').attr('disabled', false);

					// Ocultar la notificación después de un tiempo
					setTimeout(() => {
						windowNotificacion.removeClass(animationClasses).addClass(hiddenClasses);
						setTimeout(() => {
							masterNotificacion.addClass('hidden');
						}, 300); // Espera la duración de la transición de salida
					}, 3000);
					$('#formu_passwords .alerta').addClass('hidden');

					$('#formu_passwords input').val('');
					window.location.reload();
				},
				beforeSend: function() {
					$('#formu_passwords button').addClass('opacity-50 cursor-not-allowed').attr('disabled', true);
				},
				error: function(res) {
					$('#formu_passwords .alerta').removeClass('hidden');
					$('#formu_passwords button').removeClass('opacity-50 cursor-not-allowed').attr('disabled', false);
					$('#formu_passwords .msg-alerta').empty();
					if (res.responseJSON.errors) {
						$.each(res.responseJSON.errors, function(key, value) {
							$('#formu_passwords .msg-alerta').append(`<li>
								` + value + `
								</li>`)
							$('#' + key).removeClass('outline-gray-300');
							$('#' + key).addClass('outline-red-500 focus:border-red-500 focus:outline-red-500');
						});
					}

				}
			});
		});
	</script>
@endsection
