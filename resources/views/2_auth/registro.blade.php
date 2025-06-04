@extends('1_plantillas.auth')

@section('contenido')
	<div class="flex min-h-full">
		<div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-15 xl:px-20">
			<div id="screen_form" class="mx-auto w-full max-w-sm lg:w-96">
				<div>
					<img class="h-10 w-auto" src="/media/logo.png" alt="Your Company">
					<h2 class="mt-8 text-2xl/9 font-bold tracking-tight text-gray-900">Regístrate</h2>
					<p class="mt-2 text-sm/6 text-gray-500">
						¿Ya tienes cuenta?
						<a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Iniciar sesión</a>
					</p>
				</div>

				<div class="mt-10">
					<div>
						<form id="form_registro" method="POST" class="space-y-2 grid grid-cols-2 gap-4">
							@csrf

							<!-- Alerta -->
							<div id="error_ventana" class="hidden col-span-2 rounded-md bg-red-50 p-4">
								<div class="flex">
									<div class="shrink-0">
										<svg class="size-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
											<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
										</svg>
									</div>
									<div class="ml-3">
										<h3 class="text-sm font-medium text-red-800">Ha ocurrido un error</h3>
										<div class="mt-2 text-sm text-red-700">
											<ul id="error_mensaje"></ul>
										</div>
									</div>
								</div>
							</div>

							<div class="col-span-2">
								<label for="nombre" class="block text-sm/6 font-medium text-gray-900">Nombre</label>
								<div class="mt-2">
									<input type="text" name="nombre" id="nombre" autocomplete="nombre" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
								</div>
							</div>

							<div class="col-span-1">
								<label for="apellido_1" class="block text-sm/6 font-medium text-gray-900">Apellido 1</label>
								<div class="mt-2">
									<input type="text" name="apellido_1" id="apellido_1" autocomplete="apellido_1" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
								</div>
							</div>

							<div class="col-span-1">
								<label for="apellido_2" class="block text-sm/6 font-medium text-gray-900">Apellido 2</label>
								<div class="mt-2">
									<input type="text" name="apellido_2" id="apellido_2" autocomplete="apellido_2" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
								</div>
							</div>

							<div class="col-span-2">
								<label for="correo" class="block text-sm/6 font-medium text-gray-900">Correo electrónico</label>
								<div class="mt-2">
									<input type="email" name="correo" id="correo" autocomplete="correo" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
								</div>
							</div>

							<div class="col-span-2">
								<label for="telefono" class="block text-sm/6 font-medium text-gray-900">Teléfono</label>
								<div class="mt-2">
									<input type="text" name="telefono" id="telefono" autocomplete="telefono" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
								</div>
							</div>

							<div class="col-span-2">
								<label for="nombre_usuario" class="block text-sm/6 font-medium text-gray-900">Nombre de usuario</label>
								<div class="mt-2">
									<input type="text" name="nombre_usuario" id="nombre_usuario" autocomplete="nombre_usuario" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
								</div>
							</div>

							<div class="col-span-1">
								<label for="password" class="block text-sm/6 font-medium text-gray-900">Contraseña</label>
								<div class="mt-2">
									<input type="password" name="password" id="password" autocomplete="current-password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
								</div>
							</div>

							<div class="col-span-1">
								<label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">Repite contraseña</label>
								<div class="mt-2">
									<input type="password" name="password_confirmation" id="password_confirmation" autocomplete="password_confirmation" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
								</div>
							</div>

							<div class="flex items-center justify-between col-span-2">
								<div class="flex gap-3">
									<div class="flex h-6 shrink-0 items-center">
										<div class="group grid size-4 grid-cols-1">
											<input id="contrato" name="contrato" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
											<svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
												<path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
												<path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
											</svg>
										</div>
									</div>
									<label for="contrato" class="block text-sm/6 text-gray-900">Acepto los <a class="text-blue-500 hover:underline" href="">términos y condiciones</a> de la cuenta.</label>
								</div>

							</div>

							<div class="col-span-2 mt-10">
								<button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Registrarse</button>
							</div>
						</form>
					</div>

				</div>
			</div>

			<div id="screen_ok" class="hidden mx-auto w-full max-w-sm lg:w-96">
				<div class="flex flex-col">
					<svg class="size-20" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
						<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
						<g id="SVGRepo_iconCarrier">
							<path opacity="0.1" d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="#59c08b"></path>
							<path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#59c08b" stroke-width="2"></path>
							<path d="M9 12L10.6828 13.6828V13.6828C10.858 13.858 11.142 13.858 11.3172 13.6828V13.6828L15 10" stroke="#59c08b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
						</g>
					</svg>

					<div class="mt-4 text-start">
						<h3 class="font-semibold text-2xl">Te has registrado correctamente.</h3>
						<p class="mt-4">Muchas gracias, tu cuenta ya está creada. Para poder entrar debes <a class="text-blue-500" href="{{ route('login') }}">iniciar sesión</a>.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="relative hidden w-0 flex-1 lg:block">
			<img class="absolute inset-0 size-full object-cover" src="https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="">
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$('#form_registro').on('submit', function(event) {
			// No recarga la página al enviar
			event.preventDefault();

			// Crea los datos
			let data = new FormData(this);

			// Solicitud
			$.ajax({
				type: "post",
				url: "{{ route('api_registro') }}",
				data: data,
				processData: false,
				contentType: false,
				dataType: "json",
				success: function(response) {
					$('#screen_form').fadeOut(200, function() {
						$('#form_registro').empty()
						$('#screen_ok').fadeIn(100)
					})
				},
				beforeSend: function() {
					$('input').removeClass('outline-red-500 focus:border-red-500 focus:outline-red-500');
					$('input').addClass('outline-gray-300 focus:border-gray-300 focus:outline-gray-300');
					$('#form_registro button').addClass('opacity-50 cursor-not-allowed').attr('disabled', true);
				},
				error: function(res) {
					$('#error_ventana').removeClass('hidden')
					$('#error_mensaje').text(res.responseJSON.msg);
					$('#form_registro button').removeClass('opacity-50 cursor-not-allowed').attr('disabled', false);

					// Resalta los campos con error
					if (res.responseJSON.errors) {
						$.each(res.responseJSON.errors, function(key, value) {
							$('#error_mensaje').append(`<li>
								` + value + `
								</li>`)
							$('#' + key).removeClass('outline-gray-300');
							$('#' + key).addClass('outline-red-500 focus:border-red-500 focus:outline-red-500');
						});
					}
				}
			});
		})
	</script>
@endsection
