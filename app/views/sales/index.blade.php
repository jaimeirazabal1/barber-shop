@extends('layouts.master')


@section('title', 'Ventas')


@section('content')

<!-- Section Header -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>
                    Ventas

                    <small class="label label-primary">{{ (empty($store) ? 'Generales' : $store->name) }}</small>
                </h1>


            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li>{{ link_to_route('sales.index', 'Ventas', $company) }}</li>
                    <li>Listado</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END Section Header -->

@if($composer_user->hasAnyAccess(['admin', 'company']))
<div class="block full">
    <div class="row">
        <div class="col-md-4">
            <label>Filtrar sucursal:</label>
            <select class="select-select2" data-placeholder="Sucursal" style="width: 100%;" id="store_id" data-sales-store="change">
                <!--option value="0">Generales</option-->
                @foreach($stores as $storeOption)
                    <option {{ ( ! empty($store) and $storeOption->id === $store->id) ? 'selected' : '' }} value="{{ $storeOption->id }}">{{ $storeOption->name }}</option>
                @endforeach
            </select>
        </div>
        <!--div class="col-md-4">
            <label>por rango de fechas:</label>
            <select class="select-select2" data-placeholder="Sucursal" style="width: 100%;" id="store_id" data-sales-store="change">

            </select>
        </div>
        <div class="col-md-4">
            <label>&nbsp;asdasdads</label>
            <button class="btn btn-success" type="submit">Filtrar</button>
        </div-->

    </div>
</div>
@endif


<!-- Tables Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Partial Responsive Block -->
        <div class="block">
            <!-- Partial Responsive Title -->
            <div class="block-title">
                <h2>Listado de Ventas</h2>
                <small class="label label-sm label-default">{{ $sales->getTotal() }} registros</small>


                    @if ( ! empty($store))
                    <div class="block-options pull-right">
                        <a href="{{ route('sales.create', [$company, 'store' => $store->id]) }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title=""><i class="fa fa-plus"></i> Generar nueva venta</a>
                    </div>
                    @endif

            </div>
            <!-- END Partial Responsive Title -->

            @if( $sales->count() )
            <table class="table table-striped table-borderless table-vcenter">
                <thead>
                    <tr>
                        <th># No. Venta</th>
                        <th>Total</th>
                        <th class="hidden-xs">Cliente</th>
                        <th>Servicios</th>
                        <th>Productos</th>
                        <th>Fecha</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td>
                            <strong># {{ $sale->id }}</strong><br />
                            <small class="text-muted">Estatus:</small>
                            @if($sale->status == 'paid')
                                <span class="label label-success">Pagado</span>
                            @else
                                <span class="label label-warning">Pendiente</span>
                            @endif
                            <br />
                            @if($sale->type == 'cash')
                                <span class="label label-default">Efectivo</span>
                            @else
                                <span class="label label-default">Tarjeta crédito/débito</span>
                            @endif
                        </td>
                        <td><i class="fa fa-dollar"></i> {{ convertIntegerToMoney($sale->total) }}</td>
                        <td class="hidden-xs">
                            @if( ! empty($sale->customer_id) )
                                {{ $sale->customer->first_name }} {{ $sale->customer->last_name }}<br />
                                <small class="text-muted">{{ $sale->customer->aka }}</small>
                            @else
                                Venta de sucursal
                            @endif
                        </td>
                        <td>
                            @if ($sale->appointment)
                                @foreach($sale->appointment->services as $service)
                                    {{ $service->name }} - <small class="text-muted">$ {{ convertIntegerToMoney($service->price) }}</small><br />
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ( ! empty($sale->products) and count($sale->products))
                                @foreach($sale->products as $product)
                                    {{ $product->pivot->quantity }} {{ $product->name }} <small class="text-muted">( $ {{ convertIntegerToMoney($product->pivot->price) }} )</small> = $ {{ convertIntegerToMoney($product->pivot->quantity * $product->pivot->price) }}<br />
                                @endforeach
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if ( ! empty($sale->appointment))
                            <p>
                                <small class="text-muted">Cita:</small><br /><small>{{ $sale->appointment->start->toDateString() }}</small>
                                <br />
                                <small>{{ $sale->appointment->start->format('g:i:s A') }} / {{ $sale->appointment->end->format('g:i:s A') }}</small>
                                <br />
                                @if ( ! empty($sale->checkin))
                                    <small class="text-muted">Entrada:</small><br /><small>{{ $sale->checkin->format('g:i:s A') }}</small>
                                    <br />
                                @endif
                                @if ( ! empty($sale->checkout))
                                    <small class="text-muted">Salida:</small><br /><small>{{ $sale->checkout->format('g:i:s A') }}</small>
                                @endif
                            </p>
                            @endif


                            <p>
                                <small class="text-muted">Fecha de venta:</small><br /><small>{{ $sale->created_at }}</small>
                            </p>

                        </td>

                        <td>
                            @if($sale->comments)
                                <button type="button" class="btn btn-default btn-xs" data-toggle="popover" data-placement="top" data-title="Comentario" data-content="{{ $sale->comments }}" data-trigger="hover"><i class="fa fa-comment"></i></button>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ( $sale->status == 'pending')
                                <a href="{{ route('sales.edit', [$company, $sale->id, 'store' => $store->id]) }}" class="btn btn-effect-ripple btn-info  btn-sm">Editar venta</a>

                                {{ Form::open(array('route' => array('sales.update', $company, $sale->id, 'store' => $store->id), 'method' => 'PATCH', 'class' => 'form-inline','data-destroy-resource' => '', 'data-destroy-resource-message' => 'Estas a punto de registrar la cita como PAGADA. ¿Deseas continuar?')) }}
                                <button type="submit" class="btn btn-effect-ripple btn-success btn-sm" data-toggle="popover" data-placement="top"><i class="fa fa-dollar"></i> Pagar</button>
                                {{ Form::close() }}

                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center">
                {{ $sales->links() }}
            </div>

            @else
            <p>
                No existen registros de <strong>Ventas</strong> aún.
            </p>
            @endif
        </div>
        <!-- END Partial Responsive Block -->
    </div>

</div>
<!-- END Tables Row -->


@stop


@section('javascript')

@stop