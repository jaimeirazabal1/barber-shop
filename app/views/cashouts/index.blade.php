@extends('layouts.master')


@section('title', 'Cortes de caja')


@section('content')

<!-- Section Header -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>
                    Cortes de caja
                    <small class="label label-primary">{{ (empty($store) ? 'Generales' : $store->name) }}</small>
                </h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li>{{ link_to_route('app.dashboard', 'Dashboard', $company) }}</li>
                    <li>Cortes de caja</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END Section Header -->

<!-- Tables Row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Partial Responsive Block -->
        <div class="block">
            <!-- Partial Responsive Title -->
            <div class="block-title">
                <h2>Listado de Cortes de caja</h2>
                <small class="label label-sm label-default">{{ $cashouts->getTotal() }} registros</small>
                <div class="block-options pull-right">
                    <a href="{{ route('cashout.create', [$company, 'store' => $store_id]) }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title=""><i class="fa fa-plus"></i> Generar corte de caja</a>
                </div>
            </div>
            <!-- END Partial Responsive Title -->

            @if( $cashouts->count() )
            <table class="table table-striped table-borderless table-vcenter">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Ventas efectivo</th>
                        <th>Ventas tarjeta</th>
                        <th>Total ventas</th>
                        <th>Caja inicial</th>
                        <th>Total</th>
                        <th>Retirado</th>
                        <th>En caja</th>
                        <th>Propinas</th>
                        <th>Realizado por</th>
                        <th style="width: 80px;" class="text-center"><i class="fa fa-flash"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cashouts as $cashout)
                    <tr>
                        <td>
                            <small class="text-muted">Inicio:</small>&nbsp;
                            {{ $cashout->start->format('Y-m-d H:i:s a') }}<br />
                            <small class="text-muted">
                                Fin:
                            </small>&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ $cashout->end->format('Y-m-d H:i:s a') }}
                        </td>
                        <td>
                            <i class="fa fa-dollar"></i>{{ convertIntegerToMoney($cashout->money_on_cash) }}
                        </td>
                        <td>
                            <i class="fa fa-dollar"></i>{{ convertIntegerToMoney($cashout->money_on_card) }}
                        </td>
                        <td>
                            <span class="label label-info"><i class="fa fa-dollar"></i>{{ convertIntegerToMoney($cashout->money_on_cash + $cashout->money_on_card) }}</span>
                        </td>
                        <td>
                            {{ convertIntegerToMoney($cashout->initial_register) }}
                        </td>
                        <td>
                            <span class="label label-default">${{ convertIntegerToMoney($cashout->initial_register + $cashout->money_on_cash + $cashout->money_on_card) }}</span>
                        </td>
                        <td><i class="fa fa-dollar"></i>{{ convertIntegerToMoney($cashout->withdraw) }}</td>
                        <td><i class="fa fa-dollar"></i>{{ convertIntegerToMoney($cashout->cash_left_on_register) }}</td>
                        <td>${{ convertIntegerToMoney($cashout->tips) }}</td>
                        <td>{{ $cashout->user->first_name }} {{ $cashout->user->last_name }}</td>
                        <td>
                            {{ Form::open(array('method' => 'POST', 'route' => ['cashout.pdf', $company]))  }}

                            {{ Form::hidden('cashout_id', $cashout->id) }}
                            {{ Form::hidden('store_id', $store->id) }}
                            <button type="submit" class="btn btn-xs btn-default"><i class="fa fa-file-pdf-o"></i> PDF</button>
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center">
                {{ $cashouts->links() }}
            </div>

            @else
            <p>
                <strong>No</strong> existen registros de Corte de caja aún.
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