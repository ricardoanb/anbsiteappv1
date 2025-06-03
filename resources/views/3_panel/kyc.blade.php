@extends('1_plantillas.panel')

@section('contenido')
	<!-- Cuentas -->
	<div class="sec space-y-7">
		<div class="aaa">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold text-gray-900">Panel de KYC</h1>
					<p class="mt-2 text-sm text-gray-700">Los datos KYC nos permiten validar tu autenticidad.</p>
				</div>
			</div>
		</div>

		@if (!$usuario->kyc)
			<div class="sec">

				<div class="mt-5 flow-root overflow-hidden">
					<div class="aaa">
						<form id="kyc_form" enctype="multipart/form-data">
							@csrf
							<div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
								<div class="sm:col-span-3">
									<label for="nombre_completo" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
									<div class="mt-1">
										<input type="text" name="nombre_completo" id="nombre_completo" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-3">
									<label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
									<div class="mt-1">
										<input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-2">
									<label for="tipo_documento" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
									<div class="mt-1">
										<select id="tipo_documento" name="tipo_documento" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
											<option value="dni">DNI</option>
											<option value="passport">Pasaporte</option>
											<option value="nie">NIE</option>
										</select>
									</div>
								</div>

								<div class="sm:col-span-2">
									<label for="numero_documento" class="block text-sm font-medium text-gray-700">Número de Documento</label>
									<div class="mt-1">
										<input type="text" name="numero_documento" id="numero_documento" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-2">
									<label for="pais_emision" class="block text-sm font-medium text-gray-700">País de Emisión</label>
									<div class="mt-1">
										<select id="pais_emision" name="pais_emision" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
											<option value="ES">España</option>
											<!-- Add more countries as needed -->
										</select>
									</div>
								</div>

								<div class="sm:col-span-3">
									<label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
									<div class="mt-1">
										<input type="text" name="direccion" id="direccion" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-1">
									<label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
									<div class="mt-1">
										<input type="text" name="codigo_postal" id="codigo_postal" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-2">
									<label for="ciudad" class="block text-sm font-medium text-gray-700">Ciudad</label>
									<div class="mt-1">
										<input type="text" name="ciudad" id="ciudad" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-2">
									<label for="provincia" class="block text-sm font-medium text-gray-700">Provincia</label>
									<div class="mt-1">
										<input type="text" name="provincia" id="provincia" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-2">
									<label for="pais_residencia" class="block text-sm font-medium text-gray-700">País de Residencia</label>
									<div class="mt-1">
										<select id="pais_residencia" name="pais_residencia" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
											<option value="ES">España</option>
											<!-- Add more countries as needed -->
										</select>
									</div>
								</div>

								<div class="sm:col-span-3">
									<label for="telefono" class="block text-sm font-medium text-gray-700">Número de Teléfono</label>
									<div class="mt-1">
										<input type="tel" name="telefono" id="telefono" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-3">
									<label for="correo_electronico" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
									<div class="mt-1">
										<input type="email" name="correo_electronico" id="correo_electronico" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-6">
									<label for="fuente_fondos" class="block text-sm font-medium text-gray-700">Fuente de Fondos</label>
									<div class="mt-1">
										<input type="text" name="fuente_fondos" id="fuente_fondos" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-2">
									<label for="documento_frontal" class="block text-sm font-medium text-gray-700">Documento Frontal</label>
									<div class="mt-1">
										<input type="file" name="documento_frontal" id="documento_frontal" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-2">
									<label for="documento_trasero" class="block text-sm font-medium text-gray-700">Documento Trasero</label>
									<div class="mt-1">
										<input type="file" name="documento_trasero" id="documento_trasero" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

								<div class="sm:col-span-2">
									<label for="selfie_documento" class="block text-sm font-medium text-gray-700">Selfie con Documento</label>
									<div class="mt-1">
										<input type="file" name="selfie_documento" id="selfie_documento" class="px-2.5 py-2 border border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
									</div>
								</div>

							</div>

							<div class="mt-4">
								<button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Enviar KYC</button>
							</div>
						</form>
					</div>
				</div>

			</div>
		@else
			<div>
				<dl class="mt-5 grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white border border-gray-200 md:grid-cols-2 md:divide-x md:divide-y-0">
					<div class="p-3">
						<dt class="text-xs font-normal text-gray-500">Estado de comprobación</dt>
						<dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
							<div class="flex items-baseline text-md font-normal text-gray-600">
								{{ ucfirst($usuario->kyc->estado) }}
							</div>
						</dd>
					</div>
					<div class="p-3">
						<dt class="text-xs text-gray-500 font-normal">Último envío</dt>
						<dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
							<div class="text-md font-normal text-gray-600">
								<div>
									{{ Carbon\Carbon::parse($usuario->kyc->created_at)->locale('es')->translatedFormat('d F \d\e Y - H:i\h') }}
								</div>
							</div>
						</dd>
					</div>
				</dl>
			</div>
		@endif

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
