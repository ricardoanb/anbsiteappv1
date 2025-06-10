@extends('1_plantilla.panel')

@section('contenido')
	<div class="space-y-12 max-w-5xl">

		<div class="">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold text-gray-900">Centro de wallets</h1>
					<p class="mt-2 text-sm text-gray-700">Lista de todas las wallets.</p>
				</div>
				<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
					<a href="{{ route('panel_enviar') }}">
						<button type="button" class="block rounded-md bg-indigo-600 px-2.5 py-1.5 text-center text-xs font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-pointer">Transferir</button>
					</a>
				</div>
			</div>
			<div class="mt-8 flow-root">

				<!-- Lista -->
				<ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-2 xl:grid-cols-3 xl:gap-x-8">
					@foreach ($wallets as $wallet)
						<li class="overflow-hidden rounded-xl border border-gray-200">
							<div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-3 overflow-auto">
								<div class="text-sm/6 font-medium text-gray-900" title="{{ $wallet->direccion }}">{{ $wallet->direccion }}</div>
							</div>
							<dl class="grid grid-cols-2 divide-x divide-gray-100 text-sm/6">
								<div class="p-3 py-2">
									<dt class="text-gray-500">Red:</dt>
									<dd class="flex items-start gap-x-2">
										<div class="font-medium text-gray-900">ER20</div>
									</dd>
								</div>
								<div class="p-3 py-2">
									<dt class="text-gray-500">Estado</dt>
									<dd class="flex items-start gap-x-2">
										<div class="font-medium text-gray-900">Conectada</div>
									</dd>
								</div>
							</dl>
						</li>
					@endforeach

				</ul>
			</div>
		</div>

	</div>
@endsection
