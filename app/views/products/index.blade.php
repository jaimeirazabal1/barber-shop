@extends('layouts.master')


@section('title', 'Productos')


@section('content')

    <!-- Section Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Productos</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>{{ link_to_route('admin.dashboard', 'Dashboard', $company) }}</li>
                        <li>Productos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END Section Header -->

    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                {{ Form::open(['method' =>'GET', 'route' =>  ['products.index', $company], 'class' => 'form-inline', 'style' => 'margin-bottom: 15px;']) }}

                {{-- Búsqueda: -  TEXT --}}
                <div class="form-group" style="width: 50%">
                    <label for="q">Búsqueda: </label>
                    {{ Form::text('q', isset( $_GET[ 'q' ] ) ? $_GET[ 'q' ] : null, array('class' => 'form-control', 'placeholder' => 'Escribe un producto.', 'id' => 'q', 'style' => 'width: 85%')) }}
                </div>
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Buscar</button>
                <a class="btn btn-default" href="/products">Ver todos</a>

                {{ Form::close() }}
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <div class="col-lg-12">
            <!-- Partial Responsive Block -->
            <div class="block">
                <!-- Partial Responsive Title -->
                <div class="block-title">
                    <h2>Listado de Productos</h2>
                    <small class="label label-sm label-default">{{ $products->getTotal() }} registros</small>
                    <div class="block-options pull-right">
                        <a href="{{ route('products.create', $company) }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar registro"><i class="fa fa-plus"></i> Agregar</a>
                    </div>
                </div>
                <!-- END Partial Responsive Title -->

                @if( $products->count() )
                    <table class="table table-striped table-borderless table-vcenter">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="hidden-xs">Imagen</th>
                            <th class="hidden-xs">Precio</th>
                            <th class="hidden-xs">Categoría</th>
                            <th class="hidden-sm hidden-xs">Estatus</th>
                            <th style="width: 80px;" class="text-center"><i class="fa fa-flash"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td><strong>{{ link_to_route('products.edit', $product->name, array($company, $product->id))  }}</strong></td>
                                <td class="hidden-xs">
                                    @if ( $product->image )
                                        {{ HTML::image($product->image, $product->name, array('width' => '100px')) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="hidden-xs">
                                    <i class="fa fa-dollar"></i> {{ convertIntegerToMoney($product->price) }}
                                </td>
                                <td class="hidden-xs">
                                    @if ( ! empty($product->category->name))
                                        {{ $product->category->name }}
                                    @else
                                        -
                                    @endif

                                    @if (count($product->tags))

                                        <div>
                                            @foreach($product->tags as $tag)
                                                <small class="label label-default"><i class="fa fa-tag"></i> {{ $tag->name }}</small>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="hidden-sm hidden-xs">
                                    @if($product->active)
                                        <span class="label label-success">Activo</span>
                                    @else
                                        <span class="label label-default">Inactivo</span>
                                    @endif
                                </td>
                                <td width="100px" class="text-center">
                                    <a href="{{ route('products.edit', array($company, $product->id)) }}" data-toggle="tooltip" title="Editar" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>

                                    <?php $stock = ''; ?>
                                    @if (count($product->stores))
                                        @foreach($product->stores as $productStore)
                                            <?php $stock .= ( '<small class=\'badge\'>' . (empty($productStore->pivot) ? 0 : $productStore->pivot->stock)) .  '</small> ' . $productStore->name . '<br>'; ?>
                                        @endforeach
                                    @else
                                        <?php $stock = 'No disponible'; ?>
                                    @endif

                                    <button type="button" data-trigger="hover" data-toggle="popover" data-html="true" data-placement="top" data-title="Stock" data-content="{{ $stock }}" class="btn btn-sm btn-default"><i class="fa fa-cubes"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {{ $products->links() }}
                    </div>

                @else
                    <p>
                        <strong>No</strong> existen registros de Productos aún.
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