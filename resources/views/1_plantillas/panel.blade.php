<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Panel</title>

		<!-- Jquery -->
		<script src="{{ asset('/jquery.js') }}"></script>

		<script>
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
					'Authorization': 'Bearer ' + "{{ Auth::user()->remember_token }}",
				}
			});
		</script>

		<link rel="manifest" href="/manifest.webmanifest" />
		<meta name="theme-color" content="#101828" />
		<script>
			if ('serviceWorker' in navigator) {
				window.addEventListener('load', () => {
					navigator.serviceWorker.register('/service-worker.js')
						.then(reg => console.log('SW registrado ✅'))
						.catch(err => console.error('SW fallo ⛔', err));
				});
			}
		</script>

		<!-- Vite -->
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>

	<body class="h-full">
		@php
			$tituloPagina = match (Route::currentRouteName()) {
			    'panel.inicio' => 'Inicio',
			    'panel.ajustes' => 'Ajustes',

			    default => 'Panel',
			};
		@endphp

		<div>
			@include('6_fragmentos.panel.aside')
			<div class="lg:pl-72">

				@include('6_fragmentos.panel.navbar')

				<main class="p-5">
					<div class="space-y-12 max-w-5xl">
						<div class="hidden">
							<h1 class="font-bold text-gray-800 text-xl mb-7">
								{{ $tituloPagina }}
							</h1>
						</div>

						@yield('contenido')
					</div>
				</main>
			</div>
		</div>

		@yield('modales')

		@yield('scripts')
		<script src="/nav.js"></script>
	</body>

</html>
