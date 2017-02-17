@extends('layouts.master')


@section('title', 'Asistencias')
@section('module', 'ASISTENCIAS')


@section('content')

<!-- Section Header -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Asistencias <small class="label label-info">{{ $barber->first_name }} {{ $barber->last_name }}</small></h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li>{{ link_to_route('app.dashboard', 'Dashboard') }}</li>
                    <li>Asistencias</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END Section Header -->

<!-- Tables Row -->
<div class="row">
    <div class="col-lg-8">
        <!-- Partial Responsive Block -->
        <div class="block">
            <!-- Partial Responsive Title -->
            <div class="block-title">
                <h2>Listado de Asistencias</h2>
                <small class="label label-sm label-default">{{ $checkins->getTotal() }} registros</small>
                <div class="block-options pull-right">
                    {{--<a href="{{ route('barbers.checkins.create') }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar registro"><i class="fa fa-plus"></i> Agregar</a>--}}
                </div>
            </div>
            <!-- END Partial Responsive Title -->

            @if( $checkins->count() )
            <table class="table table-striped table-borderless table-vcenter">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th class="hidden-xs">Estatus</th>
                        <th style="width: 80px;" class="text-center"><i class="fa fa-flash"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checkins as $checkin)
                    <tr>
                        <td><strong>{{ $checkin->checkin->format('Y-m-d') }}</strong></td>
                        <td>
                            {{ $checkin->checkin->format('g:i:s A') }}
                        </td>
                        <td class="hidden-xs">
                            @if ($checkin->status == 'present')
                                <span class="label label-success">{{ getCheckinStatus($checkin->status) }}</span>
                            @elseif ($checkin->status == 'absence')
                                <span class="label label-danger">{{ getCheckinStatus($checkin->status) }}</span>
                            @elseif ($checkin->status == 'retardment')
                                <span class="label label-warning">{{ getCheckinStatus($checkin->status) }}</span>
                            @elseif ($checkin->status == 'excused_absence')
                                <span class="label label-default">{{ getCheckinStatus($checkin->status) }}</span>
                            @elseif ($checkin->status == 'vacation')
                                <span class="label label-default">{{ getCheckinStatus($checkin->status) }}</span>
                            @endif
                        </td>
                        <td width="100px" class="text-center">
                            <a href="{{ route('barbers.checkins.edit', [$company, $checkin->barber_id, $checkin->id]) }}" data-toggle="tooltip" title="Editar" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                            {{--{{ Form::open(array('route' => array('barbers.checkins.destroy', $checkin->id), 'method' => 'DELETE', 'class' => 'form-inline','data-delete-confirmation' => '')) }}--}}
                                    {{--{{ Form::button('<i class="fa fa-times"></i>', array('data-toggle' => 'tooltip', 'title' => 'Eliminar', 'class' => 'btn btn-effect-ripple btn-xs btn-danger','type' => 'submit')) }}--}}
                            {{--{{ Form::close() }}--}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center">
                {{ $checkins->links() }}
            </div>

            @else
            <p>
                <strong>No</strong> existen registros de Asistencias aún.
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