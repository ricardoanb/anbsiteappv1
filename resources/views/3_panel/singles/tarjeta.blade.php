@extends('1_plantillas.panel')

@section('contenido')
	<!-- Información de tarjeta -->

	<div>
		<div class="px-4 sm:px-0">
			<h3 class="text-base/7 font-semibold text-gray-900">Información de tarjeta</h3>
			<p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Gestiona todos los datos de tu tarjeta ANB</p>
		</div>
		<div class="mt-6">
			<dl class="grid grid-cols-1 sm:grid-cols-2">
				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900">Número</dt>
					<dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2">**** **** **** 1111 <br> 04/33</dd>
				</div>
				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900">CVV</dt>
					<dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2">000</dd>
				</div>

				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900">Disponible</dt>
					<dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2">
						0,00€
					</dd>
				</div>
				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900">Desactivar / Activar</dt>
					<dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2">

						<label class="inline-flex items-center cursor-pointer">
							<input type="checkbox" value="" class="sr-only peer">
							<div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
							</div>
						</label>

					</dd>
				</div>
				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-2 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900 mb-5">Ajustes</dt>
					<dd class="text-sm text-gray-900">
						<ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">

							<li class="flex items-center justify-between p-3 text-sm/6">
								<div class="flex w-0 flex-1 items-center">
									<div class="grid grid-col-1 min-w-0 flex-1">

										<div class="flex gap-3">
											<span class="text-gray-500 truncate font-medium">Withdrawal</span>
											<span class="shrink-0 text-gray-400">25/06/2025 - 15:30h</span>
										</div>

										<div class="sec">
											<span class="text-[16px] font-medium text-gray-800">1,00€</span>
										</div>
									</div>
								</div>
								<div class="ml-4 shrink-0">
									<a href="{{ route('panel.transaccion', ['id' => 1]) }}" class="font-medium text-indigo-600 hover:text-indigo-500">
										<button type="button" class="block rounded-md bg-white border border-gray-200 text-dark px-2.5 py-1.5 text-center text-xs font-semibold hover:bg-gray-50">Ver más</button>
									</a>
								</div>
							</li>

						</ul>
					</dd>
				</div>
			</dl>
		</div>
	</div>



	<!-- Historial -->
@endsection

@section('scripts')
	<script>
		data = {
			'token': localStorage.getItem('token')
		};

		$.ajax({
			type: "get",
			url: "{{ route('api.usuario.get') }}",
			data: data,
			dataType: "json",
			success: function(response) {
				console.log(response)
			}
		});
	</script>
@endsection
