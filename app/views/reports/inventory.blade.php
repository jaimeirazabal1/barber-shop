@extends('layouts.pdf')


@section('content')

	<h3 class="text-center">Inventario de Productos</h3>
	<h5 class="text-center">Reporte</h5>

	<!-- Tables Row -->
	<div class="row">

		<div class="col-lg-12">
			<div class="col-lg-12">
				<!-- Partial Responsive Block -->
				<div class="block">
					<!-- Partial Responsive Title -->
					<!-- END Partial Responsive Title -->

					<p class="text-center"><strong>{{count($products)}}</strong> productos encontrados</p>
					<br/>
					@if( count($products) )
						<h1 class="text-center">Plaza Sanzio</h1>

						<?php
						$store = '';
						$totalStock = 0;
						$total = 0;
						?>
						@foreach($products as $product)
						@if( $store != $product->category->slug )
						@if( $store != '' )
						</tbody>
						<tfoot>
						<tr>
							<td><strong>TOTAL</strong></td>
							<td></td>
							<td class="text-right"><strong>{{$totalStock}}</strong></td>
							<td></td>
							<td class="text-right"><strong>$ {{convertIntegerToMoney($total)}}</strong></td>
						</tr>
						</tfoot>
						</table>

						<?php
						$totalStock = 0;
						$total = 0;
						?>
						<!-- End -->
					@endif
				<!-- Start -->
					<br/>
					<h5 class="text-center">{{strtoupper( $product->category->name)}}</h5>
					<table class="table table-striped table-bordered table-vcenter">
						<thead>
						<th>Producto</th>
						<th>SKU</th>
						<th>Stock</th>
						<th>Precio</th>
						<th>Total</th>
						</thead>
						<tbody>
						<?php $store = $product->category->slug;?>
						@endif

						<tr>
							<td width="40%">
								<small>{{$product->name}}</small>
							</td>
							<td width="10%">{{$product->sku}}</td>
							<td class="text-right">{{$product->stores[0]->pivot->stock}}</td>
							<td class="text-right">$ {{convertIntegerToMoney($product->price)}}</td>
							<td class="text-right">
								$ {{convertIntegerToMoney($product->price * $product->stores[0]->pivot->stock)}}</td>
						</tr>

						<?php
								$totalStock += $product->stores[0]->pivot->stock;
								$total += ( $product->price * $product->stores[0]->pivot->stock );
						?>

						@endforeach
						</tbody>
						<tfoot>
						<tr>
							<td><strong>TOTAL</strong></td>
							<td></td>
							<td class="text-right"><strong>{{$totalStock}}</strong></td>
							<td></td>
							<td class="text-right"><strong>$ {{convertIntegerToMoney($total)}}</strong></td>
						</tr>
						</tfoot>
					</table>
					<!-- End -->

					<br/><br/>

					<h1 class="text-center">Providencia</h1>

					<?php
					$store = '';
					$totalStock = 0;
					$total = 0;
					?>
					@foreach($products as $product)
					@if( $store != $product->category->slug )
					@if( $store != '' )
					</tbody>
					<tfoot>
					<tr>
						<td><strong>TOTAL</strong></td>
						<td></td>
						<td class="text-right"><strong>{{$totalStock}}</strong></td>
						<td></td>
						<td class="text-right"><strong>$ {{convertIntegerToMoney($total)}}</strong></td>
					</tr>
					</tfoot>
					</table>

					<?php
					$totalStock = 0;
					$total = 0;
					?>
				<!-- End -->
					@endif
				<!-- Start -->
					<br/>
					<h5 class="text-center">{{strtoupper( $product->category->name)}}</h5>
					<table class="table table-striped table-bordered table-vcenter">
						<thead>
						<th>Producto</th>
						<th>SKU</th>
						<th>Stock</th>
						<th>Precio</th>
						<th>Total</th>
						</thead>
						<tbody>
						<?php $store = $product->category->slug;?>
						@endif

						<tr>
							<td width="40%">
								<small>{{$product->name}}</small>
							</td>
							<td width="10%">{{$product->sku}}</td>
							<td class="text-right">{{$product->stores[1]->pivot->stock}}</td>
							<td class="text-right">$ {{convertIntegerToMoney($product->price)}}</td>
							<td class="text-right">
								$ {{convertIntegerToMoney($product->price * $product->stores[1]->pivot->stock)}}</td>
						</tr>

						<?php
						$totalStock += $product->stores[1]->pivot->stock;
						$total += ( $product->price * $product->stores[1]->pivot->stock );
						?>

						@endforeach
						</tbody>
						<tfoot>
						<tr>
							<td><strong>TOTAL</strong></td>
							<td></td>
							<td class="text-right"><strong>{{$totalStock}}</strong></td>
							<td></td>
							<td class="text-right"><strong>$ {{convertIntegerToMoney($total)}}</strong></td>
						</tr>
						</tfoot>
					</table>
					<!-- End -->

					@else
						<p>
							<strong>No</strong> existe inventario.
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