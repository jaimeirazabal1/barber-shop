@extends('layouts.master')


@section('title', 'Servicios')


@section('content')

    <!-- Section Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Servicios</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>{{ link_to_route('admin.dashboard', 'Dashboard', $company) }}</li>
                        <li>Servicios</li>
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
                    <h2>Listado de Servicios</h2>
                    <small class="label label-sm label-default">{{ $services->getTotal() }} registros</small>
                    <div class="block-options pull-right">
                        <a href="{{ route('services.create', $company) }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar registro"><i class="fa fa-plus"></i> Agregar</a>
                    </div>
                </div>
                <!-- END Partial Responsive Title -->

                @if( $services->count() )
                    <table class="table table-striped table-borderless table-vcenter">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="hidden-xs">Código de Servicio</th>
                            <th class="hidden-xs">Categoría</th>
                            <th class="hidden-xs">Costo</th>
                            <th class="hidden-xs">Tiempo estimado</th>
                            <th class="hidden-sm hidden-xs">Estatus</th>
                            <th style="width: 80px;" class="text-center"><i class="fa fa-flash"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td><strong>{{ link_to_route('services.edit', $service->name, array($company, $service->id))  }}</strong></td>
                                <td class="hidden-xs">
                                    @if ($service->code)
                                        {{ $service->code }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    @if ( ! empty($service->category->name))
                                        {{ $service->category->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    <i class="fa fa-dollar"></i> {{ convertIntegerToMoney($service->price) }}
                                </td>
                                <td class="hidden-sm hidden-xs">{{ $service->estimated_time }} min</td>
                                <td class="hidden-sm hidden-xs">
                                    @if($service->active)
                                        <span class="label label-success">Activo</span>
                                    @else
                                        <span class="label label-default">Inactivo</span>
                                    @endif
                                </td>
                                <td width="100px" class="text-center">
                                    <a href="{{ route('services.edit', array($company, $service->id)) }}" data-toggle="tooltip" title="Editar" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $services->links() }}
                    </div>

                @else
                    <p>
                        <strong>No</strong> existen registros de Servicios aún.
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