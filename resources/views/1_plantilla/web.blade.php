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
		@include('3_fragmentos.web.nav')

		<main class="max-w-7xl p-6 lg:px-8 mx-auto">
			@yield('contenido')
		</main>
		@yield('scripts')
	</body>

</html>
