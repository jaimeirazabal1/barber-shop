@extends('layouts.pdf')


@section('content')

	<h3 class="text-center">Importe de ventas de productos</h3>
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

						<table class="table table-striped table-borderless table-vcenter">
							<thead>
							<tr>
								<th>Sucursal</th>
								<th>Efectivo</th>
								<th>Tarjeta</th>
								<th>Total</th>
							</tr>
							</thead>
							<tbody>

							<?php $sumTotalCash = $sumTotalCard = 0; ?>

							@foreach($stores as $store)


								<tr>
									<td>
										{{ $store->name }}
									</td>
									<td>
										$ {{ empty($data_results[$store->id]['cash']) ? '0' : convertIntegerToMoney($data_results[$store->id]['cash']) }}</td>
									<td>
										$ {{ empty($data_results[$store->id]['card']) ? '0' : convertIntegerToMoney($data_results[$store->id]['card']) }}</td>
									<?php
									$sumTotalCash += (empty($data_results[$store->id]['cash']) ? 0 : $data_results[$store->id]['cash']);
									$sumTotalCard += (empty($data_results[$store->id]['card']) ? 0 : $data_results[$store->id]['card']);
									?>
									<td>
										$ {{ convertIntegerToMoney((empty($data_results[$store->id]['cash']) ? 0 : $data_results[$store->id]['cash']) + (empty($data_results[$store->id]['card']) ? 0 : $data_results[$store->id]['card'])) }}</td>
								</tr>
							@endforeach

							</tbody>
							<tfoot>
							<tr>
								<td><span class="label label-default">Total</span></td>
								<td><b>$ {{ convertIntegerToMoney($sumTotalCash) }}</b></td>
								<td><b>$ {{ convertIntegerToMoney($sumTotalCard) }}</b></td>
								<td><b>$ {{ convertIntegerToMoney($sumTotalCash + $sumTotalCard) }}</b></td>
							</tr>
							</tfoot>
						</table>


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