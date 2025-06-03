@extends('1_plantillas.panel')

@section('contenido')
	<!-- Cuentas -->
	<div>
		<div class="px-4 sm:px-0">
			<h3 class="text-base/7 font-semibold text-gray-900">Información de transacción</h3>
			<p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Vistazo rápido a la transacción</p>
		</div>
		<div class="mt-6">
			<dl class="grid grid-cols-1 sm:grid-cols-2">
				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 col-span-2 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900">Tarjeta</dt>
					<dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2">**** 0001</dd>
				</div>
				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 col-span-2 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900">Fecha de registro</dt>
					<dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2">Jueves, 25/06/2025 - 12:00:30h</dd>
				</div>
				<div class="border-t border-gray-100 px-4 py-6 col-span-1 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900">Monto</dt>
					<dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2">0,01€</dd>
				</div>
				<div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900">Otras opciones</dt>
					<dd class="mt-2 text-sm text-gray-900">
						<ul role="list">
							<li class="flex items-center justify-between text-sm/6">
								<button type="button" class="block rounded-md bg-red-600 px-2.5 py-1.5 text-center text-xs font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Reportar</button>
							</li>
						</ul>
					</dd>
				</div>
			</dl>
		</div>
	</div>
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
