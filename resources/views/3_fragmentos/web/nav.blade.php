@php
	use App\Models\CategoriasWeb;
	$paginas = CategoriasWeb::get();
@endphp

<header class="bg-white sticky top-0 w-full left-0 top-0">
	<nav class="mx-auto flex max-w-7xl items-center justify-between gap-x-6 p-6 lg:px-8" aria-label="Global">
		<div class="flex lg:flex-1">
			<a href="/" class="-m-1.5 p-1.5">
				<span class="sr-only">Your Company</span>
				<img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="">
			</a>
		</div>
		<div class="hidden lg:flex lg:gap-x-12">
			@foreach ($paginas as $pagina)
				<a href="{{ route('web_pagina', ['id' => $pagina['slug']]) }}" class="text-sm/6 font-semibold text-gray-900">{{ ucfirst($pagina['nombre']) }}</a>
			@endforeach
		</div>
		<div class="flex flex-1 items-center justify-end gap-x-6">
			<a href="{{ route('login') }}" class="hidden text-sm/6 font-semibold text-gray-900 lg:block">Iniciar sesión</a>
			<a href="{{ route('registro') }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Regístrate</a>
		</div>
		<div class="flex lg:hidden">
			<button type="button" id="bopenmenu" class="hover:ring ring-gray-300 cursor-pointer -m-2.5 inline-flex items-center justify-center rounded-md p-1.5 text-gray-700">
				<span class="sr-only">Open main menu</span>
				<svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
					<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
				</svg>
			</button>
		</div>
	</nav>
	<!-- Mobile menu, show/hide based on menu open state. -->
	<div id="mobile-menu" class="lg:hidden hidden" role="dialog" aria-modal="true">
		<!-- Background backdrop, show/hide based on slide-over state. -->
		<div class="fixed inset-0 z-10"></div>
		<div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
			<div class="flex items-center gap-x-6">
				<a href="/" class="-m-1.5 p-1.5">
					<span class="sr-only">Your Company</span>
					<img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="">
				</a>
				<a href="{{ route('registro') }}" class="ml-auto rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Regístrate</a>
				<button id="btoggle_nav" type="button" class="focus:outline-gray-500 hover:ring ring-gray-300 cursor-pointer -m-2.5 rounded-md p-1.5 text-gray-700">
					<span class="sr-only">Close menu</span>
					<svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
			<div class="mt-6 flow-root">
				<div class="-my-6 divide-y divide-gray-500/10">
					<div class="space-y-2 py-6">
						@foreach ($paginas as $pagina)
							<a href="{{ route('web_pagina', ['id' => $pagina['slug']]) }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">{{ ucfirst($pagina['nombre']) }}</a>
						@endforeach
					</div>
					<div class="py-6">
						<a href="{{ route('login') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Iniciar sesión</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const mobileMenu = document.getElementById('mobile-menu');
		const toggleButton = document.getElementById('btoggle_nav');
		const bopenmenu = document.getElementById('bopenmenu');

		toggleButton.addEventListener('click', function() {
			const isHidden = mobileMenu.classList.contains('hidden');
			if (isHidden) {
				mobileMenu.classList.remove('hidden');
			} else {
				mobileMenu.classList.add('hidden');
			}
		});

		bopenmenu.addEventListener('click', function() {
			const isHidden = mobileMenu.classList.contains('hidden');
			if (isHidden) {
				mobileMenu.classList.remove('hidden');
			} else {
				mobileMenu.classList.add('hidden');
			}
		});
	});
</script>
