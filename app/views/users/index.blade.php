@extends('layouts.master')


@section('title', 'Usuarios')
@section('module', 'USUARIOS')


@section('content')

    <!-- Section Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Usuarios</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>{{ link_to_route('app.dashboard', 'Dashboard', $company) }}</li>
                        <li>Usuarios</li>
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
                    <h2>Listado de Usuarios</h2>
                    <!--small class="label label-sm label-default">{{ (count($users) - 1) }} registros</small-->
                    <div class="block-options pull-right">
                        <a href="{{ route('users.create', $company) }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar registro"><i class="fa fa-plus"></i> Agregar</a>
                    </div>
                </div>
                <!-- END Partial Responsive Title -->

                @if( $users->count() )
                    <table class="table table-striped table-borderless table-vcenter">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="hidden-xs">E-mail</th>
                            <th class="hidden-xs">Perfil</th>
                            <th>Sucursal</th>
                            <th class="hidden-sm hidden-xs">Estatus</th>
                            <th style="width: 80px;" class="text-center"><i class="fa fa-flash"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            {{-- Lista los usuarios que no son la empresa, solo sucursales o customers --}}
                            @if ( $composer_user->hasAccess('company') and $composer_user->id == $user->id)

                            @elseif ( $user->hasAccess('customer'))

                            @else
                                <tr>
                                    <td><strong>{{ $user->first_name . ' ' . $user->last_name  }}</strong></td>
                                    <td class="hidden-xs">{{ $user->email }}</td>
                                    <td class="hidden-xs">
                                        @if ( $user->getGroups()->first()->name == 'Empresa')
                                            Administrador
                                        @else
                                            {{ $user->getGroups()->first()->name }}
                                        @endif
                                    </td>
                                    <td>{{ $user->store_name }}</td>
                                    <td class="hidden-sm hidden-xs">
                                        @if($user->activated)
                                            <span class="label label-success">Activo</span>
                                        @else
                                            <span class="label label-default">Inactivo</span>
                                        @endif
                                    </td>
                                    <td width="100px" class="text-center">
                                        <a href="{{ route('users.edit', [$company, $user->id]) }}" data-toggle="tooltip" title="Editar" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                                        {{-- Form::open(array('route' => array('users.destroy', $user->id), 'method' => 'DELETE', 'class' => 'form-inline','data-delete-confirmation' => '')) --}}
                                        {{-- Form::button('<i class="fa fa-times"></i>', array('data-toggle' => 'tooltip', 'title' => 'Eliminar', 'class' => 'btn btn-effect-ripple btn-xs btn-danger','type' => 'submit')) --}}
                                        {{-- Form::close() --}}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{-- $users->links() --}}
                    </div>

                @else
                    <p>
                        <strong>No</strong> existen registros de Usuarios aún.
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