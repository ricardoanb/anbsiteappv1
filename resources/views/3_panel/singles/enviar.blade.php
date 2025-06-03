@extends('1_plantillas.panel')

@section('contenido')
	<!-- Cuentas -->
	<div class="space-y-5">
		<div class="px-4 sm:px-0">
			<h3 class="text-base/7 font-semibold text-gray-900">Enviar dinero</h3>
			<p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Haz una transferencia rápida a tus contactos.</p>
		</div>

		<!-- Formulario 1 -->
		<form id="form_step_1" action="">
			@csrf
			<div class="hidden max-w-lg alerta text-white bg-red-500 border border-red-700 p-3 rounded-lg text-sm">

			</div>
			<div class="max-w-lg mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">

				<!-- Step 1: Tus cuentas -->
				<div id="step1" class="col-span-2 space-y-3">
					<div class="font-semibold text-gray-900">
						<span class="text-base/7">Tus cuentas</span>
					</div>
					<fieldset aria-label="cuentas" class="col-span-2 relative -space-y-px rounded-md bg-white">
						@foreach ($cuentas as $cuenta)
							<label aria-label="{{ $cuenta->numero_identificador }}" class="group flex cursor-pointer border border-gray-200 p-4 first:rounded-tl-md first:rounded-tr-md last:rounded-br-md last:rounded-bl-md focus:outline-hidden has-checked:relative has-checked:border-indigo-200 has-checked:bg-indigo-50 md:grid md:grid-cols-[1fr_auto] md:pr-6 md:pl-4 justify-between items-center">
								<span class="flex items-center gap-3 text-sm">
									<input name="cuenta_origen" value="{{ $cuenta->numero_identificador }}" type="radio"
										class="relative size-4 appearance-none rounded-full border border-gray-200 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-200 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden">
									<span class="font-medium text-gray-900 group-has-checked:text-indigo-900">{{ $cuenta->numero_identificador }}</span>
								</span>
								<span class="ml-auto pl-1 text-sm md:ml-0 md:pl-0 md:text-center">
									<span class="font-medium text-gray-900 group-has-checked:text-indigo-900">{{ number_format($cuenta->saldo, 2, ',', '.') }}€</span>
								</span>
							</label>
						@endforeach
					</fieldset>
					<div class="flex justify-end">
						<button type="button" data-step="2" class="next-step ml-auto block rounded-md bg-indigo-600 px-3 py-2 text-center text-xs font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Siguiente</button>
					</div>
				</div>

				<!-- Step 2: Datos del destinatario -->
				<div id="step2" class="col-span-2 space-y-3 hidden">
					<div class="col-span-2 font-semibold text-gray-900">
						<span class="text-base/7">Datos del destinatario</span>
					</div>
					<div>
						<label for="cuenta_destino" class="block text-sm/6 font-medium text-gray-700">Número de cuenta</label>
						<div class="mt-2">
							<input type="text" id="cuenta_destino" name="cuenta_destino" autocomplete="given-name" class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-200 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
						</div>
					</div>
					<div>
						<label for="usuario" class="block text-sm/6 font-medium text-gray-700">ID de usuario</label>
						<div class="mt-2">
							<input type="text" id="usuario" name="usuario" autocomplete="given-name" class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-200 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
						</div>
					</div>

					<div class="flex">
						<button type="button" data-step="1" class="prev-step block rounded-md bg-gray-400 px-3 py-2 text-center text-xs font-semibold text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Anterior</button>
						<button type="button" data-step="3" class="next-step ml-auto block rounded-md bg-indigo-600 px-3 py-2 text-center text-xs font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Siguiente</button>
					</div>
				</div>

				<!-- Step 3: Cantidad -->
				<div id="step3" class="col-span-2 space-y-3 hidden">
					<div class="sm:col-span-2">
						<label for="monto" class="block text-sm/6 font-medium text-gray-700">Cantidad</label>
						<div class="mt-2">
							<input type="text" name="monto" id="monto" class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-200 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
						</div>
					</div>

					<div class="flex">
						<button type="button" data-step="2" class="prev-step block rounded-md bg-gray-400 px-3 py-2 text-center text-xs font-semibold text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Anterior</button>
						<button type="submit" class="ml-auto block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Enviar
							dinero</button>
					</div>
				</div>

			</div>
		</form>

		<div class="hidden apn rounded-lg h-[400px] flex items-center justify-center">
			<div class="p-3">
				<div class="font-semibold">
					Transferencia realizada con éxito.
				</div>

				<small>
					El comprobante se verá reflejado dentro de la cuenta como un nuevo movimiento.
				</small>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function() {
			$('.next-step').on('click', function() {
				let currentStep = $(this).closest('[id^="step"]');
				let nextStepNumber = $(this).data('step');
				let nextStep = $('#step' + nextStepNumber);

				currentStep.fadeOut(100, function() {
					nextStep.fadeIn(300);
				});
			});

			$('.prev-step').on('click', function() {
				let currentStep = $(this).closest('[id^="step"]');
				let prevStepNumber = $(this).data('step');
				let prevStep = $('#step' + prevStepNumber);

				currentStep.fadeOut(100, function() {
					prevStep.fadeIn(300);
				});
			});

			$('#form_step_1').on('submit', function(e) {
				e.preventDefault();

				let data = new FormData(this);

				$.ajax({
					type: "post",
					url: "{{ route('apisystem.transferencia') }}",
					data: data,
					dataType: "json",
					processData: false,
					contentType: false,
					beforeSend: function() {
						$('#form_step_1').find('button[type="submit"]').addClass('opacity-50').attr('disabled', true);
					},
					success: function(response) {
						console.log(response);

						if (response.status == 200) {
							$('#form_step_1').find('button[type="submit"]').removeClass('opacity-50').attr('disabled', false);
						} else {
							$('#form_step_1').find('button[type="submit"]').removeClass('opacity-50').attr('disabled', false);
						}

						$('#form_step_1').fadeOut(400, function() {
							$('.apn').removeClass('hidden');
						})
					},
					error: function(xhr, status, error) {
						$('#form_step_1').find('button[type="submit"]').removeClass('opacity-50').attr('disabled', false);
						console.log(xhr.responseText);

						$('#form_step_1').find('input, select, textarea').removeClass('outline-red-500');
						$('#error_modal').remove();
						$('.alerta').removeClass('hidden')

						let errorList = '<ul class="list-disc pl-5">';
						if (xhr.status == 422 && xhr.responseJSON.errors) {
							let errors = xhr.responseJSON.errors;
							$.each(errors, function(field, messages) {
								$('#form_step_1').find('[name="' + field + '"]').addClass('outline-red-500').removeClass('outline-gray-200');
								errorList += '<li>' + field + ': ' + messages[0] + '</li>';
							});
							errorList += '</ul>';

							$('.alerta').empty().append(errorList);
						} else {
							$('.alerta').empty().append(xhr.statusText);
						}
					}
				});
			});
		});
	</script>

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
