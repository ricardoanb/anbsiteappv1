<div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-xs sm:gap-x-6 sm:px-6 lg:px-8">
	<button type="button" class="toggleaside -m-2.5 p-2.5 text-gray-700 lg:hidden">
		<span class="sr-only">Open sidebar</span>
		<svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
			<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
		</svg>
	</button>

	<!-- Separator -->
	<div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>

	<div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
		<form class="grid flex-1 grid-cols-1" action="#" method="GET">
			<input type="search" name="search" aria-label="Buscar..." class="col-start-1 row-start-1 block size-full bg-white pl-8 text-base text-gray-900 outline-hidden placeholder:text-gray-400 sm:text-sm/6" placeholder="Buscar...">
			<svg class="pointer-events-none col-start-1 row-start-1 size-5 self-center text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
				<path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
			</svg>
		</form>
		<div class="flex items-center gap-x-4 lg:gap-x-6">

			<a href="{{ route('panel_añadir') }}">
				<button type="button" class="cursor-pointer rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Añadir</button>
			</a>

			<!-- Separator -->
			<div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true"></div>

			<!-- Profile dropdown -->
			<div class="relative">
				<button type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
					<span class="sr-only">Open user menu</span>
					<div class="relative">

						@if (auth('api')->user()->kyc)
							@if (auth('api')->user()->kyc->estado == 'aprobado')
								<div class="absolute bottom-0 right-0">
									<svg class="size-5 -m-1" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
										<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
										<g id="SVGRepo_iconCarrier">
											<path opacity="0.1" d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="#4d79ff"></path>
											<path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#4d79ff" stroke-width="2"></path>
											<path d="M9 12L10.6828 13.6828V13.6828C10.858 13.858 11.142 13.858 11.3172 13.6828V13.6828L15 10" stroke="#4d79ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
										</g>
									</svg>
								</div>
							@endif

							@if (auth('api')->user()->kyc->estado == 'pendiente')
								<div class="absolute bottom-0 right-0">
									<svg class="size-5 -m-1" viewBox="0 0 24 24" fill="#faffb3" xmlns="http://www.w3.org/2000/svg" stroke="#fbff1f">
										<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
										<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
										<g id="SVGRepo_iconCarrier">
											<path opacity="0.1" d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="#9faa03"></path>
											<path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#9faa03" stroke-width="2"></path>
											<path d="M12 7L12 11.5L12 11.5196C12 11.8197 12.15 12.1 12.3998 12.2665V12.2665L15 14" stroke="#9faa03" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M3 4L4 3" stroke="#9faa03" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M21 4L20 3" stroke="#9faa03" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
										</g>
									</svg>
								</div>
							@endif

							@if (auth('api')->user()->kyc->estado == 'rechazado')
								<div class="absolute bottom-0 right-0">
									<svg class="size-5 -m-1 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
										<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
									</svg>
								</div>
							@endif
						@endif

						<img class="size-8 rounded-full bg-gray-50" src="https://cdn.pfps.gg/pfps/6100-pingu-user-icon.png" alt="">
					</div>
					<span class="hidden lg:flex lg:items-center">
						<span class="ml-4 text-sm/6 font-semibold text-gray-900" aria-hidden="true">{{ Auth::user()->nombre }}</span>
						<svg class="ml-2 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
							<path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
						</svg>
					</span>
				</button>

				<div id="dropdown-menu" class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-hidden hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
					<!-- Active: "bg-gray-50 outline-hidden", Not Active: "" -->
					<a href="{{ route('panel_ajustes') }}" class="hover:bg-gray-50 block px-3 py-1 text-sm/6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-0">Ajustes</a>
					<a href="{{ route('logout') }}" class="hover:bg-gray-50 block px-3 py-1 text-sm/6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-1">Cerrar sesión</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const userMenuButton = document.getElementById('user-menu-button');
		const dropdownMenu = document.getElementById('dropdown-menu');

		userMenuButton.addEventListener('click', () => {
			const isHidden = dropdownMenu.classList.contains('hidden');
			dropdownMenu.classList.toggle('hidden', !isHidden);
		});

		document.addEventListener('click', (event) => {
			if (!userMenuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
				dropdownMenu.classList.add('hidden');
			}
		});
	});

	const toggleAsideButtons = document.querySelectorAll('.toggleaside');
	const mobileAside = document.getElementById('mobile-aside');

	toggleAsideButtons.forEach(button => {
		button.addEventListener('click', () => {
			if (mobileAside) {
				mobileAside.classList.toggle('hidden');
			}
		});
	});
</script>
