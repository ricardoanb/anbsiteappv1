@extends('1_plantilla.panel')

@section('contenido')
	<div class="space-y-12 max-w-5xl">

		<!-- Cuentas -->
		<div class="space-y-10">
			<!-- Encabezamiento -->
			<div class="aaa">
				<div>
					<div class=" sm:px-0">
						<h3 class="text-base/7 font-semibold text-gray-900">Detalles de la cuenta</h3>
					</div>
					<div class="mt-6 border-t border-gray-100">
						<dl class="divide-y divide-gray-100">
							<div class="py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
								<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 flex gap-4">

									<a href="{{ route('panel_enviar') }}">
										<button type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
											Enviar dinero
										</button>
									</a>

								</dd>
							</div>

							<div class="grid grid-cols-2 gap-5">
								<div class="py-6 sm:grid sm:grid-cols-1 sm:gap-1 sm:px-0">
									<dt class="text-sm/6 font-medium text-gray-900">Saldo actual</dt>
									<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ number_format($cuenta->saldo, 2, ',', '.') }}€</dd>
								</div>
								<div class="py-6 sm:grid sm:grid-cols-1 sm:gap-1 sm:px-0">
									<dt class="text-sm/6 font-medium text-gray-900">Número de cuenta</dt>
									<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $cuenta->numero_cuenta }}</dd>
								</div>
							</div>

						</dl>
					</div>
				</div>
			</div>

			<!-- Movimientos -->
			<div class="aaa">
				<div class="sm:flex sm:items-center">
					<div class="sm:flex-auto">
						<h1 class="text-base font-semibold text-gray-900">Movimientos</h1>
						<p class="mt-2 text-sm text-gray-700">Mira tus últimos movimientos</p>
					</div>
				</div>
				<div class="mt-8 flow-root">
					<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
						<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
							<table class="min-w-full divide-y divide-gray-300">
								<thead>
									<tr>
										<th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold whitespace-nowrap text-gray-900 sm:pl-0">Tipo</th>
										<th scope="col" colspan="2" class="px-4 py-3.5 text-right text-sm font-semibold whitespace-nowrap text-gray-900">Detalle</th>
									</tr>
								</thead>
								<tbody class="divide-y divide-gray-200 bg-white">

									@if (count($cuenta->movimientos) > 0)
										@foreach ($cuenta->movimientos as $movimiento)
											<tr>
												<td class="py-2 pr-3 pl-4 text-sm whitespace-nowrap text-gray-500 sm:pl-0">
													<div class="font-normal flex gap-2 items-center">
														<div class="icon">
															@switch($movimiento->tipo)
																@case('Ingreso')
																	<svg class="size-4" fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
																		<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
																		<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
																		<g id="SVGRepo_iconCarrier">
																			<title>plus-database</title>
																			<path
																				d="M4 26.016q0 1.632 1.6 3.008t4.384 2.176 6.016 0.8q0.128 0 0.352 0t0.32-0.032q-2.24-1.568-3.488-4.096-4.064-0.384-6.624-1.792t-2.56-3.456v3.392zM4 20q0 1.984 2.336 3.552t6.048 2.144q-0.384-1.472-0.384-2.688 0-0.096 0.128-1.28-3.648-0.512-5.888-1.824t-2.24-3.264v3.36zM4 14.016q0 2.016 2.4 3.584t6.176 2.144q0.64-2.112 2.048-3.776-3.008-0.128-5.408-0.8t-3.808-1.856-1.408-2.688v3.392zM4 8q0 1.632 1.6 3.008t4.384 2.208 6.016 0.8q0.128 0 0.384-0.032t0.352 0q2.848-1.984 6.272-1.984 0.544 0 1.632 0.16 1.568-0.832 2.464-1.888t0.896-2.272v-1.984q0-1.632-1.6-3.008t-4.384-2.176-6.016-0.832-6.016 0.832-4.384 2.176-1.6 3.008v1.984zM14.016 23.008q0 2.432 1.184 4.512t3.296 3.296 4.512 1.216 4.512-1.216 3.264-3.296 1.216-4.512q0-1.824-0.704-3.488t-1.92-2.88-2.88-1.92-3.488-0.704-3.488 0.704-2.88 1.92-1.92 2.88-0.704 3.488zM18.016 23.008q0-2.080 1.44-3.52t3.552-1.472 3.52 1.472 1.472 3.52-1.472 3.552-3.52 1.44-3.552-1.44-1.44-3.552zM20 24h2.016v2.016h1.984v-2.016h2.016v-1.984h-2.016v-2.016h-1.984v2.016h-2.016v1.984zM27.104 12.832q0.192 0.064 0.896 0.448v-2.656q0 1.216-0.896 2.208z">
																			</path>
																		</g>
																	</svg>
																@break

																@case('Abono')
																	<svg class="size-4" fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
																		<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
																		<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
																		<g id="SVGRepo_iconCarrier">
																			<title>plus-database</title>
																			<path
																				d="M4 26.016q0 1.632 1.6 3.008t4.384 2.176 6.016 0.8q0.128 0 0.352 0t0.32-0.032q-2.24-1.568-3.488-4.096-4.064-0.384-6.624-1.792t-2.56-3.456v3.392zM4 20q0 1.984 2.336 3.552t6.048 2.144q-0.384-1.472-0.384-2.688 0-0.096 0.128-1.28-3.648-0.512-5.888-1.824t-2.24-3.264v3.36zM4 14.016q0 2.016 2.4 3.584t6.176 2.144q0.64-2.112 2.048-3.776-3.008-0.128-5.408-0.8t-3.808-1.856-1.408-2.688v3.392zM4 8q0 1.632 1.6 3.008t4.384 2.208 6.016 0.8q0.128 0 0.384-0.032t0.352 0q2.848-1.984 6.272-1.984 0.544 0 1.632 0.16 1.568-0.832 2.464-1.888t0.896-2.272v-1.984q0-1.632-1.6-3.008t-4.384-2.176-6.016-0.832-6.016 0.832-4.384 2.176-1.6 3.008v1.984zM14.016 23.008q0 2.432 1.184 4.512t3.296 3.296 4.512 1.216 4.512-1.216 3.264-3.296 1.216-4.512q0-1.824-0.704-3.488t-1.92-2.88-2.88-1.92-3.488-0.704-3.488 0.704-2.88 1.92-1.92 2.88-0.704 3.488zM18.016 23.008q0-2.080 1.44-3.52t3.552-1.472 3.52 1.472 1.472 3.52-1.472 3.552-3.52 1.44-3.552-1.44-1.44-3.552zM20 24h2.016v2.016h1.984v-2.016h2.016v-1.984h-2.016v-2.016h-1.984v2.016h-2.016v1.984zM27.104 12.832q0.192 0.064 0.896 0.448v-2.656q0 1.216-0.896 2.208z">
																			</path>
																		</g>
																	</svg>
																@break

																@case('Transferencia')
																	<svg class="size-4" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
																		<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
																		<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
																		<g id="SVGRepo_iconCarrier">
																			<title>Transfer</title>
																			<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<g id="Transfer">
																					<rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24"> </rect>
																					<path d="M19,7 L5,7 M20,17 L5,17" id="Shape" stroke="#0C0310" stroke-width="2" stroke-linecap="round"> </path>
																					<path d="M16,3 L19.2929,6.29289 C19.6834,6.68342 19.6834,7.31658 19.2929,7.70711 L16,11" id="Path" stroke="#0C0310" stroke-width="2" stroke-linecap="round"> </path>
																					<path d="M8,13 L4.70711,16.2929 C4.31658,16.6834 4.31658,17.3166 4.70711,17.7071 L8,21" id="Path" stroke="#0C0310" stroke-width="2" stroke-linecap="round"> </path>
																				</g>
																			</g>
																		</g>
																	</svg>
																@break

																@case('Retirada')
																	<svg class="size-4" fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
																		<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
																		<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
																		<g id="SVGRepo_iconCarrier">
																			<path d="M22,2H2A1,1,0,0,0,1,3v8a1,1,0,0,0,1,1H5v9a1,1,0,0,0,1,1H18a1,1,0,0,0,1-1V12h3a1,1,0,0,0,1-1V3A1,1,0,0,0,22,2ZM7,20V18a2,2,0,0,1,2,2Zm10,0H15a2,2,0,0,1,2-2Zm0-4a4,4,0,0,0-4,4H11a4,4,0,0,0-4-4V8H17Zm4-6H19V7a1,1,0,0,0-1-1H6A1,1,0,0,0,5,7v3H3V4H21Zm-9,5a3,3,0,1,0-3-3A3,3,0,0,0,12,15Zm0-4a1,1,0,1,1-1,1A1,1,0,0,1,12,11Z"></path>
																		</g>
																	</svg>
																@break

																@default
															@endswitch
														</div>
														<div class="font-bold text-xs"> {{ json_decode($movimiento->assets)->monto }}€</div>
													</div>
												</td>
												<td colspan="2" class="px-4 py-2 text-sm whitespace-nowrap text-gray-900">

													<div class="flex flex-col items-end text-right gap-1">
														@if ($movimiento->estado == 'pendiente')
															<span class="inline-flex items-center rounded-md bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">PENDIENTE</span>
														@endif
														<div class="text-gray-500 text-sm">{{ Carbon\Carbon::parse($movimiento->created_at)->translatedFormat('d F, H:i\h') }}</div>
													</div>
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td colspan="4" class="py-2 pr-3 pl-4 text-sm whitespace-nowrap text-gray-500 sm:pl-0">
												No tienes ningún movimiento en esta cuenta.
											</td>
										</tr>
									@endif

								</tbody>
							</table>
						</div>
					</div>
				</div>


			</div>
		</div>
	@endsection
