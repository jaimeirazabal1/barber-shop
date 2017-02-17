@extends('layouts.master')


@section('title', 'Sucursales')


@section('content')

    <!-- Section Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Sucursales</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>{{ link_to_route('admin.dashboard', 'Dashboard', $company) }}</li>
                        <li>Sucursales</li>
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
                    <h2>Listado de Sucursales</h2>
                    <small class="label label-sm label-default">{{ $stores->getTotal() }} registros</small>
                    <div class="block-options pull-right">
                        <a href="{{ route('stores.create', $company) }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar registro"><i class="fa fa-plus"></i> Agregar</a>
                    </div>
                </div>
                <!-- END Partial Responsive Title -->

                @if( $stores->count() )
                    <table class="table table-striped table-borderless table-vcenter">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="hidden-xs">Dirección</th>
                            <th class="hidden-xs">Teléfono</th>
                            <th class="hidden-xs">Email</th>
                            <th>Administrador</th>
                            <th class="hidden-sm hidden-xs">Estatus</th>
                            <th style="width: 80px;" class="text-center"><i class="fa fa-flash"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stores as $store)
                            <tr>
                                <td><strong>{{ link_to_route('stores.edit', $store->name, array($company, $store->id))  }}</strong>
                                    <br />
                                    <small class="text-muted">
                                        @if($store->is_matrix)
                                            Matriz
                                        @else
                                            Sucursal
                                        @endif

                                    </small>
                                </td>
                                <td class="hidden-xs">{{ nl2br($store->address) }}</td>
                                <td class="hidden-xs">
                                    @if ( empty($store->phone))
                                        -
                                    @else
                                        <small>
                                            <span class="label label-info"><i class="fa fa-phone"></i></span>
                                            {{ $store->phone }}
                                        </small>
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    @if ( empty($store->email))
                                        -
                                    @else
                                        <a data-toggle="tooltip" title="Escribir email" href="mailto:{{ $store->email }}"><i class="fa fa-pencil-square-o"></i></a> {{ $store->email }}
                                    @endif
                                </td>
                                <td>{{ empty($store->user) ? '-' : ($store->user->first_name . ' ' . $store->user->last_name)  }}</td>
                                <td class="hidden-sm hidden-xs">
                                    @if($store->active)
                                        <span class="label label-success">Activo</span>
                                    @else
                                        <span class="label label-default">Inactivo</span>
                                    @endif
                                </td>
                                <td width="100px" class="text-center">
                                    <a href="{{ route('stores.edit', array($company, $store->id)) }}" data-toggle="tooltip" title="Editar" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                                    <a data-toggle="tooltip" title="Abrir checador" class="btn btn-info btn-xs btn-effect-ripple" target="_blank" href="{{ route('app.timeclock.create', [$company, $store->slug]) }}"><i class="fa fa-clock-o"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $stores->links() }}
                    </div>

                @else
                    <p>
                        <strong>No</strong> existen registros de Sucursales aún.
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