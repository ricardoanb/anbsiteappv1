<header class="bg-white shadow-xs lg:static lg:overflow-y-visible">
	<div class="px-6">
		<div class="relative flex justify-between gap-5 py-3">

			<div class="flex lg:hidden block items-center md:inset-y-0 md:right-0 lg:hidden gap-5">
				<!-- Mobile menu button -->
				<button type="button" id="openMobileMenuButton" class="relative -mx-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden focus:ring-inset" aria-expanded="false">
					<span class="absolute -inset-0.5"></span>
					<span class="sr-only">Open menu</span>

					<svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
						<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
					</svg>

					<svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</button>
			</div>

			<div class="flex ml-auto items-center lg:justify-end xl:col-span-4">

				<a href="{{ route('panel.añadir') }}" class="ml-6 sm:inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Añadir fondos</a>

				<!-- Profile dropdown -->
				<div class="relative ml-4 shrink-0">
					<div>
						<button type="button" class="relative flex rounded-full bg-white focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
							<span class="absolute -inset-1.5"></span>
							<span class="sr-only">Open user menu</span>
							<img class="size-8 rounded-full object-cover" src="/media/anbi.png" alt="">
						</button>
					</div>


					<div id="user-menu-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
						<!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
						<a href="{{ route('panel.ajustes') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" role="menuitem" tabindex="-1" id="user-menu-item-0">Tu perfil</a>
						<a href="{{ route('web_logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" role="menuitem" tabindex="-1" id="user-menu-item-2">Cerrar sesión</a>
					</div>
				</div>

			</div>
		</div>
	</div>
</header>
