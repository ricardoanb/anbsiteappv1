<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>{{ env('APP_NAME') }}</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Vite -->
		@vite(['resources/css/app.css', 'resources/js/app.js'])

	</head>

	<body class="h-full">
		<div>
			@include('3_fragmentos.panel.aside')
			<div class="lg:pl-72">
				@include('3_fragmentos.panel.nav')
				<main class="lg:py-7 py-5">
					<div class="px-4 sm:px-6 lg:px-8 max-w-5xl">
						@yield('contenido')
					</div>
				</main>
			</div>
		</div>

		<!-- Global notification live region, render this permanently at the end of the document -->
		<div aria-live="assertive" style="display:none" class="z-100 notificacion_global pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
			<div class="flex w-full flex-col items-center space-y-4 sm:items-end">

				<div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black/5">
					<div class="p-4">
						<div class="flex items-start">
							<div class="shrink-0">
								<svg class="size-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
									<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
								</svg>
							</div>
							<div class="ml-3 w-0 flex-1 pt-0.5">
								<p class="text-sm font-medium text-gray-900 global_msg"></p>
								<p class="mt-1 text-sm text-gray-500 global_msg_p"></p>
							</div>
							<div class="ml-4 flex shrink-0">
								<button type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden">
									<span class="sr-only">Close</span>
									<svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
										<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
									</svg>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@yield('modales')

		@yield('scripts')

		<script>
			const cargarNotificaciones = () => {
				axios.get('/api/notificaciones-sin-leer')
					.then(res => {
						const notis = res.data;

						if (Array.isArray(notis) && notis.length > 0) {
							notis.forEach(noti => {
								const mensaje = noti?.data?.mensaje ?? 'Tienes una nueva notificación';

								// Mostrar notificación
								$('.global_msg').text('Nueva notificación');
								$('.global_msg_p').text(mensaje);
								$('.notificacion_global').fadeIn(300);

								setTimeout(() => {
									$('.notificacion_global').fadeOut(300);
								}, 5000);
							});

							// Marcar como leídas después de mostrar
							axios.post('/api/notificaciones-marcar-leidas');
						}
					})
					.catch(err => {
						console.error('Error cargando notificaciones:', err);
					});
			};

			// Ejecutar cada 5 segundos
			setInterval(cargarNotificaciones, 5000);
		</script>

	</body>

</html>
