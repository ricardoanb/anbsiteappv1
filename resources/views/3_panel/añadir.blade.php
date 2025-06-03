@extends('1_plantillas.panel')

@section('contenido')
	<div class="sec">
		<h3 class="text-base font-semibold text-gray-900">Añadir fondos</h3>

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
						@foreach ($usuario->cuentas as $cuenta)
							<label aria-label="{{ $cuenta->numero_identificador }}" class="group flex cursor-pointer border border-gray-200 p-4 first:rounded-tl-md first:rounded-tr-md last:rounded-br-md last:rounded-bl-md focus:outline-hidden has-checked:relative has-checked:border-indigo-200 has-checked:bg-indigo-50 md:grid md:grid-cols-[1fr_auto] md:pr-6 md:pl-4 justify-between items-center">
								<span class="flex items-center gap-3 text-sm">
									<input name="cuenta" value="{{ $cuenta->numero_identificador }}" type="radio"
										class="relative size-4 appearance-none rounded-full border border-gray-200 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-200 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden">
									<span class="font-medium text-gray-900 group-has-checked:text-indigo-900">{{ $cuenta->numero_identificador }}</span>
								</span>
								<span class="ml-auto pl-1 text-sm md:ml-0 md:pl-0 md:text-center">
									<span class="font-medium text-gray-900 group-has-checked:text-indigo-900">{{ number_format($cuenta->saldo, 2, ',', '.') }}€</span>
								</span>
							</label>
						@endforeach
					</fieldset>

					<div class="sm:col-span-2">
						<label for="monto" class="block text-sm/6 font-medium text-gray-700">Monto</label>
						<div class="mt-2">
							<input type="text" name="monto" id="monto" class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-200 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
						</div>
					</div>

					<div class="flex justify-end">
						<button type="submit" data-step="2" class="next-step ml-auto block rounded-md bg-indigo-600 px-3 py-2 text-center text-xs font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Añadir fondos</button>
					</div>
				</div>

			</div>
		</form>
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

	<script>
		$('#form_step_1').on('submit', function(event) {
			event.preventDefault();

			let data = new FormData(this);

			$.ajax({
				type: "post",
				url: "{{ route('api.añadir.fondos') }}",
				data: data,
				dataType: "json",
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#form_step_1').find('button').addClass('cursor-not-allowed opacity-50').prop('disabled', true)
				},
				success: function(response) {
					console.log(response)
					window.location.href = response.url;
				},
				error: function(res) {
					if (res.responseJSON && res.responseJSON.errors) {
						let errors = res.responseJSON.errors;
						$('.alerta').html('').removeClass('hidden');
						for (let field in errors) {
							$(`[name="${field}"]`).removeClass('outline-gray-200').addClass('outline-red-500');
							$('.alerta').append(`<p>${errors[field][0]}</p>`);
						}
					} else {
						$('.alerta').html('Ha ocurrido un error inesperado.').removeClass('hidden');
					}
					console.log(res);
					$('#form_step_1').find('button').removeClass('cursor-not-allowed opacity-50').prop('disabled', false)
				}
			});
		})
	</script>
@endsection
