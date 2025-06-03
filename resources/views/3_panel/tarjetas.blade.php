@extends('1_plantillas.panel')

@section('contenido')
	<!-- Tarjetas -->
	<div class="sec">
		<div class="aaa">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold text-gray-900">Tarjetas</h1>
					<p class="mt-2 text-sm text-gray-700">Todas tus tarjetas de ANB.</p>
				</div>
				<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
					<button type="button" class="block rounded-md bg-indigo-600 px-2.5 py-1.5 text-center text-xs font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Crear tarjeta</button>
				</div>
			</div>
		</div>
		<div class="mt-5 flow-root overflow-hidden">
			<div class="aaa">
				<table class="w-full text-left">
					<thead class="bg-white">
						<tr>
							<th scope="col" class="relative isolate py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">
								Cuenta
								<div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-b-gray-200"></div>
								<div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-b-gray-200"></div>
							</th>
							<th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Disponible</th>
							<th scope="col" class="relative py-3.5 pl-3">
								<span class="sr-only">Ver</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="relative py-4 pr-3 text-sm font-medium text-gray-900">
								**** 0123
								<div class="absolute right-full bottom-0 h-px w-screen bg-gray-100"></div>
								<div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100"></div>
							</td>
							<td class="px-3 py-4 text-sm text-gray-500 text-end">0,00€</td>
							<td class="relative py-4 pl-3 text-right text-sm font-medium">
								<a href="{{ route('panel.tarjeta.single', ['id' => 1]) }}" class="text-indigo-600 hover:text-indigo-900">Ver<span class="sr-only">, **** 0123</span></a>
							</td>
						</tr>

						<!-- More people... -->
					</tbody>
				</table>
			</div>
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
