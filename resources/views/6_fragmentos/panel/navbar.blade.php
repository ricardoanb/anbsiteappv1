<header class="bg-white shadow-xs lg:static lg:overflow-y-visible">
	<div class="px-6">
		<div class="relative flex justify-between gap-5">

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
			<div class="min-w-0 flex-1 lg:px-0">
				<div class="flex items-center py-4 lg:mx-0 lg:max-w-xl px-0">
					<div class="grid w-full grid-cols-1">
						<input type="search" name="search" class="col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pr-3 pl-10 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Search">
						<svg class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
							<path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
						</svg>
					</div>
				</div>
			</div>

			<div class="flex items-center lg:justify-end xl:col-span-4">
				<button type="button" class="sm:block hidden relative shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden">
					<span class="absolute -inset-1.5"></span>
					<span class="sr-only">View notifications</span>
					<svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
						<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
					</svg>
				</button>

				<!-- Profile dropdown -->
				<div class="relative sm:ml-5 shrink-0">
					<div>
						<button type="button" class="relative flex rounded-full bg-white focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
							<span class="absolute -inset-1.5"></span>
							<span class="sr-only">Open user menu</span>
							<img class="size-8 rounded-full object-cover" src="{{ Auth::user()->avatar }}" alt="">
						</button>
					</div>

					<div id="user-menu-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
						<!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
						<a href="{{ route('panel.ajustes') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" role="menuitem" tabindex="-1" id="user-menu-item-0">Tu perfil</a>
						<a href="{{ route('web_logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" role="menuitem" tabindex="-1" id="user-menu-item-2">Cerrar sesión</a>
					</div>
				</div>

				<a href="#" class="lg:block hidden ml-6 sm:inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Subir</a>
			</div>
		</div>
	</div>
</header>
