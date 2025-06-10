@extends('1_plantilla.panel')

@section('contenido')
	<!-- Sección -->
	<div class="mx-auto max-w-2xl space-y-16 sm:space-y-10 lg:mx-0 lg:max-w-none">

		@if (!$kyc || (isset($kyc->estado) && $kyc->estado == 'rechazado'))
			@if (isset($kyc->estado) && $kyc->estado == 'rechazado')
				<div class="rounded-md bg-red-50 p-4">
					<div class="flex">
						<div class="shrink-0">
							<svg class="size-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
								<path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
							</svg>
						</div>
						<div class="ml-3">
							<h3 class="text-sm font-medium text-red-800">Acciones requeridas</h3>
							<div class="mt-2 text-sm text-red-700">
								<span> Su validación ha fallado, compruebe los datos que ha enviado antes de enviar para evitar errores y más retrasos.
								</span>
							</div>
						</div>
					</div>
				</div>
			@endif
			<form id="form_kyc" method="POST">
				@csrf
				<div>
					<h2 class="text-base/7 font-semibold text-gray-900">Verificación KYC</h2>
					<p class="mt-1 text-sm/6 text-gray-500">Rellena tus datos personales</p>

					<dl class="mt-6 divide-y divide-gray-100 border-t border-gray-200 text-sm/6">
						@php
							$kyc = Auth::user()->kyc;
						@endphp

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Teléfono</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<input type="text" name="telefono" value="{{ $kyc->telefono ?? '' }}" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Fecha de nacimiento</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<input type="date" name="fecha_nacimiento" value="{{ $kyc->fecha_nacimiento ?? '' }}" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">País de nacimiento</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<input type="text" name="pais_nacimiento" value="{{ $kyc->pais_nacimiento ?? '' }}" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">País de origen</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<input type="text" name="pais_origen" value="{{ $kyc->pais_origen ?? '' }}" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Tipo de documento</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<select class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200" name="tipo_documento" id="tipo_documento">
									<option value="documento nacional">Documento nacional</option>
									<option value="pasaporte">Pasaporte</option>
								</select>
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Número de documento</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<input type="text" name="numero_documento" value="{{ $kyc->numero_documento ?? '' }}" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Dirección postal</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<input type="text" name="direccion_postal" value="{{ $kyc->direccion_postal ?? '' }}" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Código postal</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<input type="text" name="codigo_postal" value="{{ $kyc->codigo_postal ?? '' }}" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Ciudad</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<input type="text" name="ciudad" value="{{ $kyc->ciudad ?? '' }}" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Provincia</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<input type="text" name="provincia" value="{{ $kyc->provincia ?? '' }}" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Selfie</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto flex justify-between">
								<label for="foto_selfie">
									<span class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
										Subir
									</span>
								</label>
								<input type="file" hidden name="foto_selfie" id="foto_selfie" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200" onchange="previewFile(event, 'preview_selfie')">
								<img id="preview_selfie" class="w-[40px] rounded" src="#" alt="Preview Selfie" style="display: none;">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Anverso del documento</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto flex justify-between">
								<label for="anverso_documento">
									<span class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
										Subir
									</span>
								</label>
								<input type="file" hidden name="anverso_documento" id="anverso_documento" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200" onchange="previewFile(event, 'preview_anverso')">
								<img id="preview_anverso" class="w-[40px] rounded" src="#" alt="Preview Anverso" style="display: none;">
							</dd>
						</div>

						<div class="py-6 sm:flex">
							<dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">Reverso del documento</dt>
							<dd class="mt-1 sm:mt-0 sm:flex-auto flex justify-between">
								<label for="reverso_documento">
									<span class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
										Subir
									</span>
								</label>
								<input type="file" hidden name="reverso_documento" id="reverso_documento" class="p-1 px-2 rounded lg:max-w-xs w-full ring ring-gray-200" onchange="previewFile(event, 'preview_reverso')">
								<img id="preview_reverso" class="w-[40px] rounded" src="#" alt="Preview Reverso" style="display: none;">
							</dd>
						</div>

						<script>
							function previewFile(event, previewId) {
								const file = event.target.files[0];
								const preview = document.getElementById(previewId);

								if (file) {
									const reader = new FileReader();
									reader.onload = function(e) {
										preview.src = e.target.result;
										preview.style.display = 'block';
									};
									reader.readAsDataURL(file);
								} else {
									preview.src = '#';
									preview.style.display = 'none';
								}
							}
						</script>

						<div class="py-6 sm:flex">
							<dd class="mt-1 sm:mt-0 sm:flex-auto">
								<button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
									Actualizar
								</button>
							</dd>
						</div>
					</dl>
				</div>
			</form>
		@else
			<div class="space-y-5">

				<dl class="mx-auto grid grid-cols-1 ring ring-gray-100 gap-px bg-gray-900/5 sm:grid-cols-2 lg:grid-cols-2">
					<div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-0 bg-white px-4 py-5 sm:px-6 xl:px-8">
						<dt class="text-sm/6 font-medium text-gray-500">Estado</dt>
						<dd class="w-full flex-none text-xl/10 font-medium tracking-tight text-gray-900">{{ ucfirst($kyc->estado) }}</dd>
					</div>
					<div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-0 bg-white px-4 py-5 sm:px-6 xl:px-8">
						<dt class="text-sm/6 font-medium text-gray-500">Enviado el:</dt>
						<dd class="w-full flex-none text-xl/10 font-medium tracking-tight text-gray-900">
							{{ Carbon\Carbon::parse($kyc->created_at)->format('l, d M') }}
						</dd>
					</div>
				</dl>

				<dl>
					<small>
						No tiene que hacer más nada, verificaremos su identidad lo antes posible. Hay casos que puede demorar hasta 24 horas. En el momento de que sea aprobado podrá ver que el icono posterior de usuario cambia a un check, si se rechaza, este se pondrá rojo y deberá volver a rellenar el formulario.
					</small>
				</dl>

			</div>
		@endif
	</div>

	<!-- NOTIFICACION -->
	<div id="notificacion" class="z-100 pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6 hidden" aria-live="assertive">
		<div class="flex w-full flex-col items-center space-y-4 sm:items-end">
			<!-- Notification panel -->
			<div id="notificacion-panel" class="transition transform ease-out duration-300 translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2 pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black/5">
				<div class="p-4">
					<div class="flex items-start">
						<div class="shrink-0">
							<svg class="size-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
							</svg>
						</div>
						<div class="ml-3 w-0 flex-1 pt-0.5">
							<p id="notificacion-titulo" class="text-sm font-medium text-gray-900">¡Guardado!</p>
							<p id="notificacion-mensaje" class="mt-1 text-sm text-gray-500">Los cambios se han guardado correctamente.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {

			$('#form_kyc').on('submit', function(event) {
				event.preventDefault();

				// Llamar al formulario
				var formulario = $(this);

				// Serializa los parámetros
				let datos = new FormData(this);

				// Crea la petición
				$.ajax({
					type: "post",
					url: "{{ route('api.kyc.crear') }}",
					data: datos,
					contentType: false,
					processData: false,
					dataType: "json",
					beforeSend: function() {
						$(formulario).find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true);
					},
					success: function(response) {
						$('html').fadeOut(300, function() {
							window.location.reload();
						});
						console.log(respones)
					},
					error: function(response) {
						// setear errores de validación
						let errores = response.responseJSON.errores;
						let mensaje = response.responseJSON.mensaje;

						// Limpiar errores anteriores
						$('.error-span').remove();

						// Mostrar errores específicos en los inputs
						if (errores) {
							for (let campo in errores) {
								let input = $(`[name="${campo}"]`);
								let errorSpan = `<div class="error-span text-red-500 text-sm">${errores[campo][0]}</div>`;
								input.after(errorSpan);
							}
						}

						// Mostrar mensaje general si existe
						if (mensaje) {
							$('.alerta').removeClass('hidden');
							$('#mensaje_alerta').empty().append(mensaje);
						}

						// Desactivamos el botón
						$(formulario).find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false);
					}
				});
			})
		});
	</script>
@endsection
