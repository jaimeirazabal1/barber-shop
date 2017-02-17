@extends('layouts.pdf')

@section('content')

	<h3 class="text-center">Número de clientes atendidos</h3>
	<h5 class="text-center">Reporte</h5>

	<!-- Tables Row -->
	<div class="row">

		<div class="col-lg-12">

			<div class="col-lg-12">
				<!-- Partial Responsive Block -->
				<div class="block">
					<!-- Partial Responsive Title -->
					<!-- END Partial Responsive Title -->

					@if( count($data_results) )
						@foreach($stores as $store)

							<?php $sumTotal = 0; ?>

							<table class="table table-striped table-borderless table-vcenter">
								<caption><h2>{{ $store->name }}</h2></caption>
								<thead>
								<tr>
									<th>Barbero</th>
									<th>Clientes atendidos</th>
								</tr>
								</thead>
								<tbody>
								@if ( count($store->barbers) <= 0)
									<tr>
										<td colspan="2">No hay barberos asignados a la sucursal.</td>
									</tr>
								@else
									@foreach($store->barbers as $barber)
										<tr>
											<td>
												{{ $barber->first_name }} {{ $barber->last_name }}
											</td>
											<td>{{ empty($data_results[$store->id]['barbers'][$barber->id]['total']) ? '0' : $data_results[$store->id]['barbers'][$barber->id]['total'] }}</td>
											<?php
											$sumTotal += (empty($data_results[$store->id]['barbers'][$barber->id]['total']) ? 0 : $data_results[$store->id]['barbers'][$barber->id]['total'])
											?>
										</tr>
									@endforeach
								@endif
								</tbody>
								<tfoot>
								<tr>
									<td><span class="label label-default">Total</span></td>
									<td><b>{{ $sumTotal }}</b></td>
								</tr>
								</tfoot>
							</table>
						@endforeach

					@else
						<p>
							<strong>No</strong> existen registros de Barberos aún.
						</p>
					@endif
				</div>
				<!-- END Partial Responsive Block -->
			</div>

		</div>
		<!-- END Tables Row -->

	</div>

@stop

@stop