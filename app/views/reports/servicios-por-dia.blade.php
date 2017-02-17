@extends('layouts.pdf')

@section('content')

	<h3 class="text-center">Número de servicios por día</h3>
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
								<th>Fecha</th>
								<th>Total de servicios</th>
							</tr>
							</thead>
							<tbody>
							<?php $sumTotal = 0; ?>
							@foreach($data_results as $date => $result)
								<tr>
									<td>{{ $date }}</td>
									<td>{{ $result['total'] }}</td>
								</tr>
								<?php $sumTotal += $result['total'] ?>
							@endforeach
							</tbody>
							<tfoot>
							<tr>
								<td><span class="label label-default">Total</span></td>
								<td><b>{{ $sumTotal }}</b></td>
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