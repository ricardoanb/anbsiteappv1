@extends('1_plantillas.auth')

@section('contenido')
	<div class="flex min-h-full items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
		<div class="w-full max-w-sm space-y-10">
			<div>
				<img class="mx-auto h-10 w-auto" src="/media/logo.png" alt="Your Company">
				<h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Iniciar sesión</h2>
			</div>

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
			<form class="space-y-6 relative" id="form_login" action="#" method="POST">
				@csrf
				<div class="hidden loadw absolute top-0 left-0 bg-white/30 w-full h-full flex items-center justify-center">
					<div class="loader"></div>
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
						<label for="remember-me" class="block text-sm/6 text-gray-900">Recordar</label>
					</div>

					<div class="text-sm/6">
						<a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Olvidé mi contraseña</a>
					</div>
				</div>

				<div>
					<button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Iniciar sesión</button>
				</div>
			</form>

			<p class="text-center text-sm/6 text-gray-500">
				¿No tienes cuenta?
				<a href="{{ route('web_registro') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Registrate gratis</a>
			</p>
		</div>
	</div>
@endsection


@section('scripts')
	<script>
		$('#form_login').on('submit', function(event) {
			// No recarga la página al enviar
			event.preventDefault();

			// Crea los datos
			let data = new FormData(this);

			// Solicitud
			$.ajax({
				type: "post",
				url: "{{ route('api_login') }}",
				data: data,
				processData: false,
				contentType: false,
				dataType: "json",
				success: function(response) {
					$('#error_ventana').addClass('hidden');
					localStorage.setItem('token', response.token);
					$('body').fadeOut(300, function() {
						window.location.href = '{{ route('panel.inicio') }}'
					})
				},
				beforeSend: function() {
					$('.loadw').removeClass('hidden');
					$('#form_login button').addClass('opacity-50 cursor-not-allowed').attr('disabled', true);
				},
				error: function(res) {
					$('#error_ventana').removeClass('hidden')
					$('#error_mensaje').text(res.responseJSON.error);
					$('.loadw').addClass('hidden');
					$('#form_login button').removeClass('opacity-50 cursor-not-allowed').attr('disabled', false);
				}
			});
		})
	</script>
@endsection
