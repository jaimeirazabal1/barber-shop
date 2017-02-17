@extends('layouts.master')


@section('title', 'Proveedores')


@section('content')

    <!-- Section Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Proveedores</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>{{ link_to_route('admin.dashboard', 'Dashboard', $company) }}</li>
                        <li>Proveedores</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END Section Header -->

    <!-- Tables Row -->
    <div class="row">
        <div class="col-lg-10">
            <!-- Partial Responsive Block -->
            <div class="block">
                <!-- Partial Responsive Title -->
                <div class="block-title">
                    <h2>Listado de Proveedores</h2>
                    <small class="label label-sm label-default">{{ $suppliers->getTotal() }} registros</small>
                    <div class="block-options pull-right">
                        <a href="{{ route('suppliers.create', $company) }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar registro"><i class="fa fa-plus"></i> Agregar</a>
                    </div>
                </div>
                <!-- END Partial Responsive Title -->

                @if( $suppliers->count() )
                    <table class="table table-striped table-borderless table-vcenter">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="hidden-xs">Email</th>
                            <th class="hidden-xs">Teléfono</th>
                            <th style="width: 80px;" class="text-center"><i class="fa fa-flash"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td><strong>{{ link_to_route('suppliers.edit', $supplier->name, array($company, $supplier->id))  }}</strong></td>
                                <td class="hidden-xs">
                                    @if ($supplier->email)
                                        <a data-toggle="tooltip" title="Escribir email" href="mailto:{{ $supplier->email }}"><i class="fa fa-pencil-square-o"></i></a> {{ $supplier->email }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    @if ($supplier->phone)
                                        {{ $supplier->phone }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td width="100px" class="text-center">
                                    <a href="{{ route('suppliers.edit', array($company, $supplier->id)) }}" data-toggle="tooltip" title="Editar" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $suppliers->links() }}
                    </div>

                @else
                    <p>
                        <strong>No</strong> existen registros de Proveedores aún.
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