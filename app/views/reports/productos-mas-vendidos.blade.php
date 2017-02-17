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

					@if( count($results) )

						<table class="table table-striped table-borderless table-vcenter">
							<thead>
							<tr>
								<th>Producto</th>
								<th>Código de producto</th>
								<th>Inventario</th>
								<th>Ventas</th>
							</tr>
							</thead>
							<tbody>
							<?php $sumTotal = 0; ?>
							@foreach($results as $result)
								<tr>
									<td>{{ $result->product_name }}</td>
									<td>{{ $result->product_sku }}</td>
									<td>{{ $result->product_stock }}</td>
									<td>{{ $result->product_sales }}</td>
								</tr>
								<?php $sumTotal += $result->product_sales ?>
							@endforeach
							</tbody>
							<tfoot>
							<tr>
								<td align="right" colspan="3"><span class="label label-default">Total general</span>
								</td>
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