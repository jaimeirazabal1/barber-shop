@extends('layouts.master')


@section('title', 'Barberos')


@section('content')

    <!-- Section Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Barberos</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>{{ link_to_route('admin.dashboard', 'Dashboard', $company) }}</li>
                        <li>Barberos</li>
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
                    <h2>Listado de Barberos</h2>
                    <small class="label label-sm label-default">{{ $barbers->getTotal() }} registros</small>
                    <div class="block-options pull-right">
                        <a href="{{ route('barbers.create', $company) }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar registro"><i class="fa fa-plus"></i> Agregar</a>
                    </div>
                </div>
                <!-- END Partial Responsive Title -->

                @if( $barbers->count() )
                    <table class="table table-striped table-borderless table-vcenter">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="hidden-xs">Email</th>
                            <th class="hidden-xs">Teléfono</th>
                            <th class="hidden-xs">Sucursal</th>
                            <th class="hidden-sm hidden-xs">Estatus</th>
                            <th>Asistencias</th>
                            <th>Horario</th>
                            <th style="width: 80px;" class="text-center"><i class="fa fa-flash"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($barbers as $barber)
                            <tr>
                                <td><strong>{{ link_to_route('barbers.edit', $barber->first_name . ' ' . $barber->last_name, array($company, $barber->id))  }}</strong></td>
                                <td class="hidden-xs">
                                    @if ($barber->email)
                                        <a data-toggle="tooltip" title="Escribir email" href="mailto:{{ $barber->email }}"><i class="fa fa-pencil-square-o"></i></a> {{ $barber->email }}
                                    @else
                                        <p>
                                            -
                                        </p>
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    @if ($barber->phone or $barber->cellphone)
                                        @if ( $barber->phone )

                                            <small>
                                                <span class="label label-info"><i class="fa fa-phone"></i></span>
                                                {{ $barber->phone }}
                                            </small><br />
                                        @endif
                                        @if ($barber->cellphone)
                                            <small>
                                                <span class="label label-info"><i class="fa fa-mobile-phone"></i></span>
                                                {{ $barber->cellphone }}
                                            </small>

                                        @endif
                                    @else
                                        <p>-</p>
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    {{ $barber->store->name }} <br>
                                    <small class="text-muted">
                                        @if ($barber->store->is_matrix)
                                            Matriz
                                        @else
                                            Sucursal
                                        @endif
                                    </small>
                                </td>
                                <td class="hidden-sm hidden-xs">
                                    @if($barber->active)
                                        <span class="label label-success">Activo</span>
                                    @else
                                        <span class="label label-default">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('barbers.checkins.index', [$company, $barber->id]) }}" class="btn btn-xs btn-info btn-effect-ripple"><i class="fa fa-clock-o"></i> Registro</a>
                                </td>
                                <td>
                                    <small><span class="text-muted">Entrada:</span> {{ Carbon\Carbon::createFromFormat('H:i:s', $barber->check_in)->format('g:i A') }}</small><br />
                                    <small><span class="text-muted">Comida Inicio:</span> {{ Carbon\Carbon::createFromFormat('H:i:s', $barber->mealtime_in)->format('g:i A') }}</small><br />
                                    <small><span class="text-muted">Comida Fin:</span> {{ Carbon\Carbon::createFromFormat('H:i:s', $barber->mealtime_out)->format('g:i A') }}</small><br />
                                    <small><span class="text-muted">Salida:</span> {{ Carbon\Carbon::createFromFormat('H:i:s', $barber->check_out)->format('g:i A') }}</small><br />
                                </td>
                                <td width="100px" class="text-center">
                                    <a href="{{ route('barbers.edit', array($company, $barber->id)) }}" data-toggle="tooltip" title="Editar" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $barbers->links() }}
                    </div>

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


@stop


@section('javascript')

@stop