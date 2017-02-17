@extends('layouts.master')


@section('title', 'Clientes')


@section('content')

    <!-- Section Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Clientes</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>{{ link_to_route('admin.dashboard', 'Dashboard', $company) }}</li>
                        <li>Clientes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END Section Header -->


    <!-- Tables Row -->
    <div class="row">

        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    @if ( ! empty($filter))
                        <h4>Resultado de búsqueda para : {{ $filter }}</h4>
                    @endif
                </div>
                {{ Form::open(array('method' => 'GET', 'route' => ['customers.index', $company], 'class' => 'form-inline', 'style' => 'padding-bottom: 20px; width: 50%;')) }}
                    <div class="form-group" style="width: 50%;">
                        {{ Form::label('s', 'Buscar:', array('class' => 'sr-only')) }}
                        {{ Form::text('s', $filter, array('class' => 'form-control', 'placeholder' => 'Buscar...', 'style' => 'width: 100%;')) }}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-effect-ripple btn-default"><i class="fa fa-search"></i></button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>

        <div class="col-lg-12">
            <!-- Partial Responsive Block -->
            <div class="block">
                <!-- Partial Responsive Title -->
                <div class="block-title">
                    <h2>Listado de Clientes</h2>
                    <small class="label label-sm label-default">{{ count($customers) }} registros</small>
                    <div class="block-options pull-right">
                        <a href="{{ route('customers.create', $company) }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar registro"><i class="fa fa-plus"></i> Agregar</a>
                    </div>
                </div>
                <!-- END Partial Responsive Title -->

                @if( $customers->count() )
                    <table class="table table-striped table-borderless table-vcenter">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="hidden-xs">Email</th>
                            <th class="hidden-xs">Teléfono</th>
                            <th class="hidden-xs text-center">Usuario de sistema</th>
                            <th style="width: 80px;" class="text-center"><i class="fa fa-flash"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>
                                    <strong>{{ link_to_route('customers.edit', $customer->first_name . ' ' . $customer->last_name, array($company, $customer->id))  }}</strong>
                                    <br />
                                    @if ( $customer->aka)
                                        <small class="text-muted">Apodo: {{ $customer->aka }}</small>
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    @if ($customer->email)
                                        <a data-toggle="tooltip" title="Escribir email" href="{{ $customer->email }}"><i class="fa fa-pencil-square-o"></i></a> {{ $customer->email }}</td>
                                    @else
                                        -
                                    @endif
                                <td class="hidden-xs">
                                    @if ( $customer->phone )
                                        <small>
                                            <span class="label label-info"><i class="fa fa-phone"></i></span>
                                            {{ $customer->phone }}
                                        </small>
                                        <br />
                                    @endif
                                    @if ($customer->cellphone)
                                        <small>
                                            <span class="label label-info"><i class="fa fa-mobile-phone"></i></span>
                                            {{ $customer->cellphone }}
                                        </small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ( ! empty($customer->user_id))
                                        <span class="label label-success">Sí</span>
                                    @else
                                        <span class="label label-default">No</span>
                                    @endif
                                </td>
                                <td width="100px" class="text-center">
                                    <a href="{{ route('customers.edit', array($company, $customer->id)) }}" data-toggle="tooltip" title="Editar" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $customers->links() }}
                    </div>

                @else
                    <p>
                        <strong>No</strong> existen registros de Clientes aún.
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