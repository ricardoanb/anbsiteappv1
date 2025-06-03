<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Auth</title>

		<!-- Jquery -->
		<script src="{{ asset('/jquery.js') }}"></script>

		<script>
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
		@yield('contenido')
		@yield('scripts')
	</body>

</html>
