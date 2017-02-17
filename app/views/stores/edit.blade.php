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
                        <li>{{ link_to_route('stores.index','Sucursales', $company) }}</li>
                        <li>{{ link_to_route('stores.edit', $store->name, [$company, $store->id]) }}</li>
                        <li>Editar</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END Section Header -->


    <!-- Row -->
    <div class="row">
        <div class="col-md-8">
            <!-- Block -->
            <div class="block">

                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2>Editar información de la Sucursal</h2>
                    <div class="block-options pull-right">
                        @if ( $composer_user->hasAnyAccess(['admin', 'company']))
                        <a href="{{ route('stores.index', $company) }}" class="btn btn-effect-ripple btn-default" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Volver al listado"><i class="fa fa-chevron-circle-left"></i> Volver al listado</a>
                        @endif
                    </div>
                </div>
                <!-- END Horizontal Form Title -->


                <!-- Form Content -->
                {{ Form::model($store, array('method' => 'PATCH', 'route' => array('stores.update', $company, $store->id), 'class' => 'form-horizontal form-bordered'))  }}

                @include('stores.partials._form')

                {{ Form::close() }}
                <!-- END Form Content -->


            </div>
            <!-- END Block -->

        </div>

        <div class="col-md-4">


            <!-- Block -->
            <div class="block">

                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2>Buscar dirección</h2>
                </div>
                <!-- END Horizontal Form Title -->


                {{-- Buscar dirección -  TEXT --}}
                <div>
                    {{ Form::text('geocomplete', empty($store->formatted_address) ? null : $store->formatted_address, array('class' => 'form-control', 'placeholder' => '', 'id' => 'geocomplete')) }}

                    <div class="map_canvas_store"></div>

                </div>


            </div>
            <!-- END Block -->

        </div>
    </div>
    <!-- END Row -->


@stop


@section('javascript')
    <!-- ckeditor.js, load it only in the page you would like to use CKEditor (it's a heavy plugin to include it with the others!) -->
    {{ HTML::script('assets/admin/js/plugins/ckeditor/ckeditor.js') }}

    <!-- Load and execute javascript code used only in this page -->
    {{ HTML::script('assets/admin/js/pages/formsComponents.js') }}
    <script>$(function(){ FormsComponents.init(); });</script>
@stop