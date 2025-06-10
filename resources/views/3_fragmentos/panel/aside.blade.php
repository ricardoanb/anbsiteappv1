<!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
<div class="relative z-50 lg:hidden hidden" id="mobile-aside" role="dialog" aria-modal="true">

	<div class="fixed inset-0 bg-gray-900/80" aria-hidden="true"></div>
	<div class="fixed inset-0 flex">
		<div class="relative mr-16 flex w-full max-w-xs flex-1">
			<div class="absolute top-0 left-full flex w-16 justify-center pt-5">
				<button type="button" class="toggleaside" class="-m-2.5 p-2.5">
					<span class="sr-only">Close sidebar</span>
					<svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</button>
			</div>

			<!-- Sidebar component, swap this element with another sidebar if you like -->
			<div class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6 pb-4">
				<div class="flex h-16 shrink-0 items-center">
					<img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=white" alt="Your Company">
				</div>
				<nav class="flex flex-1 flex-col">
					<ul role="list" class="flex flex-1 flex-col gap-y-7">
						<li>
							<ul role="list" class="-mx-2 space-y-1">

								<li>
									<!-- Current: "bg-indigo-700 text-white", Default: "text-indigo-200 hover:text-white hover:bg-indigo-700" -->
									<a href="{{ route('panel_inicio') }}" class="{{ request()->is('panel') ? 'bg-indigo-700' : '' }} hover:bg-indigo-700 group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-white">
										Dashboard
									</a>
								</li>

								<li>
									<a href="{{ route('panel_cuentas') }}" class="{{ request()->routeIs('panel_cuentas') ? 'bg-indigo-700' : '' }} group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-white">
										{{-- Puedes usar un icono aquí si lo agregas a la DB --}}
										Cuentas
									</a>
								</li>

								<li>
									<a href="{{ route('panel_stakes') }}" class="{{ request()->routeIs('panel_stakes') ? 'bg-indigo-700' : '' }} group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-white">
										{{-- Puedes usar un icono aquí si lo agregas a la DB --}}
										Stakes
									</a>
								</li>

								<li>
									<a href="{{ route('panel_wallets') }}" class="{{ request()->routeIs('panel_wallets') ? 'bg-indigo-700' : '' }} group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-white">
										{{-- Puedes usar un icono aquí si lo agregas a la DB --}}
										Wallets
									</a>
								</li>

							</ul>
						</li>
						<li class="hidden">
							<div class="text-xs/6 font-semibold text-indigo-200">Your teams</div>
							<ul role="list" class="-mx-2 mt-2 space-y-1">
								<li>
									<!-- Current: "bg-indigo-700 text-white", Default: "text-indigo-200 hover:text-white hover:bg-indigo-700" -->
									<a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
										<span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">H</span>
										<span class="truncate">Heroicons</span>
									</a>
								</li>
							</ul>
						</li>

						<li class="mt-auto">
							<a href="{{ route('panel_kyc') }}" class="{{ request()->is('panel_kyc') ? 'bg-indigo-700' : '' }} group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
								KYC
							</a>
							<a href="{{ route('panel_ajustes') }}" class="{{ request()->is('panel_ajustes') ? 'bg-indigo-700' : '' }} group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
								<svg class="size-6 shrink-0 text-indigo-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
									<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
								</svg>
								Ajustes
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>

<!-- Static sidebar for desktop -->
<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
	<!-- Sidebar component, swap this element with another sidebar if you like -->
	<div class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6 pb-4">
		<div class="flex h-16 shrink-0 items-center">
			<img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=white" alt="Your Company">
		</div>
		<nav class="flex flex-1 flex-col">
			<ul role="list" class="flex flex-1 flex-col gap-y-7">
				<li>
					<ul role="list" class="-mx-2 space-y-1">

						<li>
							<!-- Current: "bg-indigo-700 text-white", Default: "text-indigo-200 hover:text-white hover:bg-indigo-700" -->
							<a href="{{ route('panel_inicio') }}" class="{{ request()->is('panel') ? 'bg-indigo-700' : '' }} hover:bg-indigo-700 group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-white">
								Dashboard
							</a>
						</li>

						<li>
							<!-- Current: "bg-indigo-700 text-white", Default: "text-indigo-200 hover:text-white hover:bg-indigo-700" -->
							<a href="{{ route('panel_cuentas') }}" class="{{ request()->routeIs('panel_cuentas') ? 'bg-indigo-700' : '' }} hover:bg-indigo-700 group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-white">
								Cuentas
							</a>
						</li>

						<li>
							<!-- Current: "bg-indigo-700 text-white", Default: "text-indigo-200 hover:text-white hover:bg-indigo-700" -->
							<a href="{{ route('panel_stakes') }}" class="{{ request()->routeIs('panel_stakes') ? 'bg-indigo-700' : '' }} hover:bg-indigo-700 group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-white">
								Stakes
							</a>
						</li>

						<li>
							<!-- Current: "bg-indigo-700 text-white", Default: "text-indigo-200 hover:text-white hover:bg-indigo-700" -->
							<a href="{{ route('panel_wallets') }}" class="{{ request()->routeIs('panel_wallets') ? 'bg-indigo-700' : '' }} hover:bg-indigo-700 group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-white">
								Wallets
							</a>
						</li>

					</ul>
				</li>
				<li class="hidden">
					<div class="text-xs/6 font-semibold text-indigo-200">Your teams</div>
					<ul role="list" class="-mx-2 mt-2 space-y-1">
						<li>
							<!-- Current: "bg-indigo-700 text-white", Default: "text-indigo-200 hover:text-white hover:bg-indigo-700" -->
							<a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
								<span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">H</span>
								<span class="truncate">Heroicons</span>
							</a>
						</li>
						<li>
							<a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
								<span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">T</span>
								<span class="truncate">Tailwind Labs</span>
							</a>
						</li>
						<li>
							<a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
								<span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">W</span>
								<span class="truncate">Workcation</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="mt-auto">
					<a href="{{ route('panel_kyc') }}" class="{{ Route::currentRouteNamed('panel_kyc') ? 'bg-indigo-700' : '' }} group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">

						<svg class="w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
							<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
							<g id="SVGRepo_iconCarrier">
								<path opacity="0.5"
									d="M9.59236 3.20031C9.34886 3.40782 9.2271 3.51158 9.09706 3.59874C8.79896 3.79854 8.46417 3.93721 8.1121 4.00672C7.95851 4.03705 7.79903 4.04977 7.48008 4.07522L7.48007 4.07523C6.67869 4.13918 6.278 4.17115 5.94371 4.28923C5.17051 4.56233 4.56233 5.17051 4.28923 5.94371C4.17115 6.278 4.13918 6.67869 4.07523 7.48007L4.07522 7.48008C4.04977 7.79903 4.03705 7.95851 4.00672 8.1121C3.93721 8.46417 3.79854 8.79896 3.59874 9.09706C3.51158 9.2271 3.40781 9.34887 3.20028 9.59239L3.20027 9.5924C2.67883 10.2043 2.4181 10.5102 2.26522 10.8301C1.91159 11.57 1.91159 12.43 2.26522 13.1699C2.41811 13.4898 2.67883 13.7957 3.20027 14.4076L3.20031 14.4076C3.4078 14.6511 3.51159 14.7729 3.59874 14.9029C3.79854 15.201 3.93721 15.5358 4.00672 15.8879C4.03705 16.0415 4.04977 16.201 4.07522 16.5199L4.07523 16.5199C4.13918 17.3213 4.17115 17.722 4.28923 18.0563C4.56233 18.8295 5.17051 19.4377 5.94371 19.7108C6.27799 19.8288 6.67867 19.8608 7.48 19.9248L7.48008 19.9248C7.79903 19.9502 7.95851 19.963 8.1121 19.9933C8.46417 20.0628 8.79896 20.2015 9.09706 20.4013C9.22711 20.4884 9.34887 20.5922 9.5924 20.7997C10.2043 21.3212 10.5102 21.5819 10.8301 21.7348C11.57 22.0884 12.43 22.0884 13.1699 21.7348C13.4898 21.5819 13.7957 21.3212 14.4076 20.7997C14.6511 20.5922 14.7729 20.4884 14.9029 20.4013C15.201 20.2015 15.5358 20.0628 15.8879 19.9933C16.0415 19.963 16.201 19.9502 16.5199 19.9248L16.52 19.9248C17.3213 19.8608 17.722 19.8288 18.0563 19.7108C18.8295 19.4377 19.4377 18.8295 19.7108 18.0563C19.8288 17.722 19.8608 17.3213 19.9248 16.52L19.9248 16.5199C19.9502 16.201 19.963 16.0415 19.9933 15.8879C20.0628 15.5358 20.2015 15.201 20.4013 14.9029C20.4884 14.7729 20.5922 14.6511 20.7997 14.4076C21.3212 13.7957 21.5819 13.4898 21.7348 13.1699C22.0884 12.43 22.0884 11.57 21.7348 10.8301C21.5819 10.5102 21.3212 10.2043 20.7997 9.5924C20.5922 9.34887 20.4884 9.22711 20.4013 9.09706C20.2015 8.79896 20.0628 8.46417 19.9933 8.1121C19.963 7.95851 19.9502 7.79903 19.9248 7.48008L19.9248 7.48C19.8608 6.67867 19.8288 6.27799 19.7108 5.94371C19.4377 5.17051 18.8295 4.56233 18.0563 4.28923C17.722 4.17115 17.3213 4.13918 16.5199 4.07523L16.5199 4.07522C16.201 4.04977 16.0415 4.03705 15.8879 4.00672C15.5358 3.93721 15.201 3.79854 14.9029 3.59874C14.7729 3.51158 14.6511 3.40781 14.4076 3.20027C13.7957 2.67883 13.4898 2.41811 13.1699 2.26522C12.43 1.91159 11.57 1.91159 10.8301 2.26522C10.5102 2.4181 10.2043 2.67883 9.5924 3.20027L9.59236 3.20031Z"
									fill="#ffffff"></path>
								<path d="M16.3736 9.86298C16.6914 9.54515 16.6914 9.02984 16.3736 8.71201C16.0557 8.39417 15.5404 8.39417 15.2226 8.71201L10.3723 13.5623L8.77753 11.9674C8.4597 11.6496 7.94439 11.6496 7.62656 11.9674C7.30873 12.2853 7.30873 12.8006 7.62656 13.1184L9.79685 15.2887C10.1147 15.6065 10.63 15.6065 10.9478 15.2887L16.3736 9.86298Z" fill="#ffffff"></path>
							</g>
						</svg>

						KYC
					</a>
					<a href="{{ route('panel_ajustes') }}" class="{{ Route::currentRouteNamed('panel_ajustes') ? 'bg-indigo-700' : '' }} group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-indigo-200 hover:bg-indigo-700 hover:text-white">
						<svg class="size-6 shrink-0 text-indigo-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
							<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
						</svg>
						Ajustes
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
