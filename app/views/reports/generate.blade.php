@extends('layouts.master')


@section('title', 'Reportes')


@section('content')

	<!-- Section Header -->
	<div class="content-header">
		<div class="row">
			<div class="col-sm-6">
				<div class="header-section">
					<h1>Generador de Reportes</h1>
				</div>
			</div>
			<div class="col-sm-6 hidden-xs">
				<div class="header-section">
					<ul class="breadcrumb breadcrumb-top">
						<li>{{ link_to_route('admin.dashboard', 'Dashboard', $company) }}</li>
						<li>Generador de Reportes</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- END Section Header -->

	<!-- Tables Row -->
	<div class="row">


		{{-- FILTROS --}}

		<div class="col-md-12">
			<!-- Horizontal Form Block -->
			<div class="block full">

				<form id="form" action="" method="GET"
				      class="form-inline">

					{{-- Rango de fechas: - DATE RANGE --}}
					<div style="margin-bottom: 1em;"
					     class="form-group  col-md-12 {{ ($errors->first('date_start') or $errors->first('date_end')) ? 'has-error' : '' }}">

						<div class="col-md-6">
							<label>Selecciona un período</label>
							<div class="input-group input-daterange" data-date-format="yyyy-mm-dd">
								<input type="text" id="date_start" name="date_start" class="form-control"
								       placeholder="Fecha inicio" required="required">
								<span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
								<input type="text" id="date_end" name="date_end" class="form-control"
								       placeholder="Fecha fin" required="required">
							</div>

							@if( $errors->first('date_start') or $errors->first('date_end'))
								<p class="help-block">{{ $errors->first('date_start') ?: $errors->first('date_end')   }}</p>
							@endif

							<br/><br/>
							<label>Elige un reporte</label>
							<div class="input-group">
								<select id="report" class="form-control" name="type" required="required">
									<option value="">(Elige un reporte)</option>
									<option value="/reports/amount-sales-by-product">Importe de ventas de productos
									</option>
									<option value="/reports/amount-sales-by-service">Importe de ventas de servicios
									</option>
									<option value="/reports/inventory">Inventario de Productos
									</option>
									<option value="/reports/customer-count-attended">Número de clientes atendidos
									</option>
									<option value="/reports/best-product-sellers">Productos más vendidos</option>
									<option value="/reports/services-by-day">Servicios por día</option>
									<option value="/reports/average-time-by-service">Tiempo promedio de servicios
									</option>
								</select>
							</div>
						</div>
					</div>

					<div style="clear: both;">
						<div class="form-group">
							<div class="col-md-12">
								<button type="submit" class="btn btn-effect-ripple btn-default"
								        style="overflow: hidden; position: relative;">Generar Reporte
								</button>
							</div>
						</div>
					</div>
				</form>

			</div>
			<!-- END Horizontal Form Block -->

			<script>
				var form = document.getElementById('form');
				var report = document.getElementById('report');
				//				report.addEventListener( 'change', function (event) {
				//					form.action = report.value;
				//				}, false )

				form.addEventListener('submit', function (event) {
					event.preventDefault();

					var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
					var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

					var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
					var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

					var w = 640;
					var h = 480;

					var left = ((width / 2) - (w / 2)) + dualScreenLeft;
					var top = ((height / 2) - (h / 2)) + dualScreenTop;

					var pdf = window.open(report.value, 'Report', 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
					pdf.focus();
					pdf.print();
//					pdf.close();
				}, false);

				//				var myWindow=window.open('','','width=200,height=100');
				//				myWindow.document.write("<p>This is 'myWindow'</p>");
				//				myWindow.document.close();
				//				myWindow.focus();
				//				myWindow.print();
				//				myWindow.close();
			</script>

		</div>
@stop


@section('javascript')

@stop