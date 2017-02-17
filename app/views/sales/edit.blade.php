@extends('layouts.master')


@section('title', 'Ventas')
@stop


        
    
@section('javascript')
    
    <!-- ckeditor.js, load it only in the page you would like to use CKEditor (it's a heavy plugin to include it with the others!) -->
    {{ HTML::script('assets/admin/js/plugins/ckeditor/ckeditor.js') }}

    <!-- Load and execute javascript code used only in this page -->
    {{ HTML::script('assets/admin/js/pages/formsComponents.js') }}
    <script>$(function(){ FormsComponents.init(); });</script>


    <script>
        $(function(){
            $.noty.defaults = {
                layout: 'topRight',
                theme: 'relax', // or 'relax'
                type: 'success',
                text: '', // can be html or string
                dismissQueue: true, // If you want to use queue feature set this true
                template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
                animation: {
                    open: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceInLeft'
                    close: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceOutLeft'
                    easing: 'swing',
                    speed: 500 // opening & closing animation speed
                },
                timeout: 10000, // delay for closing event. Set false for sticky notifications
                force: false, // adds notification to the beginning of queue when set to true
                modal: false,
                maxVisible: 1, // you can set max visible notification for dismissQueue true option,
                killer: true, // for close all notifications before show
                closeWith: ['click'], // ['click', 'button', 'hover', 'backdrop'] // backdrop click will close all notifications
                callback: {
                    onShow: function() {},
                    afterShow: function() {},
                    onClose: function() {},
                    afterClose: function() {},
                    onCloseClick: function() {}
                },
                buttons: false // an array of buttons
            };
            // $("body").on("change","#services",function(){
            //     console.log($("#services option:selected").text())
            //     console.log($("#services option:selected").data('data-price'))
            //     console.log()
            // })
            $("body").on("click",".add_service",function(e){
                e.preventDefault();
                var service_id = $("#services option:selected").val();
                var name = $("#services option:selected").text();
                var appointment_id = $("#appointment_id").val();
                console.log("appointment_id",appointment_id)
                var price = parseInt($("#services option:selected").attr('data-price'));
                var time = parseInt($("#services option:selected").attr('data-time'));
                console.log("tiempo estimado:",time)
                price = (price/100).toFixed(2);
                console.log(price)
                $.ajax({
                    url:"/sales/add_service/"+appointment_id+"/"+service_id+"/"+time,
                    type:"post",
                    data:{appointment_id:appointment_id,service_id:service_id,time:time},
                    dataType:"json",
                    success:function(r){
                        console.log(r)
                        if (r.success) {

                            var service = ''+
                            '<tr data-sales-service-item-list="'+service_id+'">'+
                                '<td>'+
                                    '<button data-service-appointment-id="'+service_id+'" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-times"></i></button>'+
                                '</td>'+
                                '<td style="width: 180px;">'+
                                    '<span data-sales-service-item="'+service_id+'" data-sales-service-price="'+price+'">'+name+'</span>'+
                                '</td>'+
                                '<td style="width: 75px;" class="text-right">'+
                                    '<strong data-sales-service-sub>$ '+price+' </strong>'+
                                '</td>'+
                            '</tr>';
                            $(".table_services").append(service);
                            var suma = 0;
                            $("[data-sales-service-sub]").each(function(){ 
                                suma += $(this).text().replace("$ ","")*100;

                            });
                            $("#subtotal").text((suma/100).toFixed(2));
                            cantidad_en_productos = parseFloat($("#productos_span").text().replace("$ ",""));
                            console.log("total productos: ",cantidad_en_productos);
                            console.log("total servicios: ",(suma/100).toFixed(2));
                            suma = parseFloat((suma/100).toFixed(2));
                            console.log(typeof suma,suma)
                            console.log(typeof cantidad_en_productos,cantidad_en_productos)
                            $("#total").val((suma+cantidad_en_productos).toFixed(2));
                        }else{
                            alert("Ocurrio un error")
                        }
                    }
                })
                
                return false;
            });
            $('[data-destroy-service-appointment]').on('click', function(e){
                e.preventDefault();
                if ( confirm('Se eliminará el servicio. ¿Deseas continuar?') )
                {
                    var $button = $(this);
                    var service_id = $button.data('service-appointment-id');

                    $.ajax({
                        url: $button.data('url'),
                        dataType: 'json',
                        type: 'DELETE',
                        success: function(response){

                            var n = noty({
                                text: '<i class="fa fa-check"></i> El servicio se ha eliminado correctamente.',
                                animation: {
                                    open: 'animated bounceInLeft', // Animate.css class names
                                    close: 'animated bounceOutLeft', // Animate.css class names
                                    easing: 'swing', // unavailable - no need
                                    speed: 500 // unavailable - no need
                                }
                            });

                            $('[data-sales-service-item-list="' + service_id + '"]').fadeOut('normal', function(){
                                $(this).remove();
                            });

                            var href = window.location.href;

                            window.location.href = href;
                        },
                        error: function(xhr, textStatus, error){

                            var msg = 'Ocurrió un error al eliminar el servicio, intente nuevamente por favor.',
                                    errors = xhr.responseJSON.error.message || {};

                            var n = noty({
                                text: '<i class="fa fa-warning"></i> ' + msg,
                                animation: {
                                    open: 'animated bounceInLeft', // Animate.css class names
                                    close: 'animated bounceOutLeft', // Animate.css class names
                                    easing: 'swing', // unavailable - no need
                                    speed: 500 // unavailable - no need
                                },
                                type: 'error'
                            });
                        },
                        complete: function(){

                        }
                    });
                }
            });
        });
    </script>

@stop


@section('content')
    <input type="hidden" value="{{ $appointment->id }}" id="appointment_id">
    <!-- Section Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>
                        Ventas

                        <small class="label label-primary">{{ (empty($store) ? 'Generales' : $store->name) }}</small>
                    </h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>{{ link_to_route('sales.index','Ventas', $company) }}</li>
                        <li>Editar venta</li>
                        <li># {{ $sale->id }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END Section Header -->


    <!-- Row -->
    <div class="row">
        <!-- Form Content -->
        {{ Form::open(array('method' => 'PATCH', 'route' => ['sales.update', $company, $sale->id, 'store' => $store->id], 'class' => 'form-horizontal form-bordered', 'data-sales-form-create' => '', 'data-destroy-resource' => '', 'data-destroy-resource-message' => 'Esta a punto de registrarse una venta como PAGADA. ¿Deseas continuar?'))  }}
        <div class="col-md-7">
            <!-- Block -->
            <div class="block">

                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2>Información de la Venta</h2>
                    <div class="block-options pull-right">
                        <a href="{{ route('sales.index', [$company, 'store' => $store->id]) }}" class="btn btn-effect-ripple btn-default" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Volver al listado"><i class="fa fa-chevron-circle-left"></i> Volver al listado</a>
                    </div>
                </div>
                <!-- END Horizontal Form Title -->

                @include('sales.partials._form')

            </div>
            <!-- END Block -->

        </div>


        <div class="col-md-5">

            <!-- Block -->
            <div class="block">

                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2>Total</h2>
                    <div class="block-options pull-right">

                    </div>
                </div>
                <!-- END Horizontal Form Title -->

                <div style="padding-bottom: 2em;">

                    <?php $subtotal_services = 0 ?>


                    @if($appointment)
                        {{-- Servicios -  TEXT --}}
                        <div class="form-group col-md-12">

                            @foreach($appointment->services as $service)
                                <?php $subtotal_services += $service->price ?>
                            @endforeach

                            {{ Form::label('subtotal_services', 'Servicios', array('class' => 'col-md-4 control-label'))  }}
                            <div class="col-md-8">
                                <p class="form-control-static">$ <span id='subtotal' data-sales-subtotal-services data-subtotal="{{ $subtotal_services }}">{{ convertIntegerToMoney($subtotal_services) }}</span></p>
                            </div>
                        </div>
                    @endif

                    {{-- Productos -  TEXT --}}
                    <div class="form-group col-md-12">

                        {{ Form::label('subtotal_products', 'Productos', array('class' => 'col-md-4 control-label'))  }}
                        <div class="col-md-8">
                            <p class="form-control-static"><span id="productos_span" data-sales-subtotal-products data-subtotal="0">$ 0.00</span></p>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                <input type="text" id="total" name="total" class="form-control" readonly aria-readonly="readonly" placeholder="0.00" value="{{ convertIntegerToMoney($subtotal_services) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Block -->
            <div class="block">

                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2>Productos</h2>
                    <div class="block-options pull-right">

                    </div>
                </div>
                <!-- END Horizontal Form Title -->

                <div style="padding-bottom: 2em;">

                    {{-- Productos -  SELECT2 --}}
                    <div style="padding-bottom: 2em;" class="">

                        <select data-sales-product-option name="products" id="products" class="select-select2" placeholder="" data-placeholder="Productos" style="width: 85%;">
                            <option value="0">Seleccionar producto</option>
                            @foreach($products as $product)
                                {{--<option data-sales-product-price="{{ $product->price }}" value="{{ $product->id }}">{{ $product->name }}</option>--}}
                                @foreach($product->stores as $storeProduct)
                                    @if ($store->id == $storeProduct->pivot->store_id and $storeProduct->pivot->stock > 0)
                                        <option data-sales-product-price="{{ $product->price }}" value="{{ $product->id }}">{{ $product->name }}
                                            @if ( ! empty($storeProduct->pivot->stock))
                                                ( {{ $storeProduct->pivot->stock }} )
                                            @else
                                                ( 0 )
                                            @endif

                                        </option>
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                        <a data-sales-product-add class="btn btn-info" href=""><i class="fa fa-plus"></i></a>
                    </div>

                    <table class="table table-striped table-borderless table-vcenter">
                        <tbody data-sales-product-list-added>
                        <!--tr>
                            <td class="text-center" style="width: 40px;">
                                <a href="javascript:void(0)" class="btn btn-effect-ripple btn-xs btn-danger pull-right"><i class="fa fa-times"></i></a>
                            </td>
                            <td style="width: 180px;">
                                <a href="img/placeholders/photos/photo11.jpg" data-toggle="lightbox-image" title="Italian Pizza Night (2 People)">
                                    Producto 1
                                </a>
                            </td>
                            <td style="width: 60px;" class="text-center">
                                <a class="btn btn-xs btn-default" href=""><i class="fa fa-plus"></i></a><input type="text" class="form-control text-center" value="1"><a class="btn btn-xs btn-default" href=""><i class="fa fa-minus"></i></a>
                            </td>
                            <td class="text-right">
                                <strong>$59</strong>
                            </td>
                        </tr-->

                        </tbody>
                        <tfoot>
                        <!--tr class="success">
                           <td colspan="3">Total</td>
                           <td class="text-right">
                               <strong>$689</strong>
                           </td>
                       </tr-->
                        </tfoot>
                    </table>

                </div>


            </div>
            <!-- END Block -->

            @if ( $appointment)
                <!-- Block -->
                <div class="block">

                    <!-- Horizontal Form Title -->
                    <div class="block-title">
                        <h2>Servicios</h2>
                        <div class="block-options pull-right">

                        </div>
                    </div>
                    <!-- END Horizontal Form Title -->

                    <div style="padding-bottom: 2em;">
                         <div style="padding-bottom: 2em;" class="">

                        <select data-sales-product-option name="services" id="services" class="select-select2" placeholder="" data-placeholder="Servicios" style="width: 85%;">
                            <option value="0">Seleccionar Servicio</option>
                            @foreach($services as $service)
                                <option data-time="{{ $service->estimated_time }}" data-price="{{ $service->price }}" value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <a data-sales-service-add class="btn btn-info add_service" href="#"><i class="fa fa-plus"></i></a>
                    </div>
                        <table class="table table-striped table-borderless table-vcenter table_services">
                            <tbody data-sales-service-list-added>
                            @foreach($appointment->services as $service)
                                <tr data-sales-service-item-list="{{ $service->id }}">
                                    <td>
                                        {{ Form::button('<i class="fa fa-times"></i>', array('data-url' => route('api.appointments.services.destroy', [$appointment->id, $service->id]), 'class' => 'btn btn-effect-ripple btn-xs btn-danger','type' => 'button', 'data-destroy-service-appointment' => '', 'data-service-appointment-id' => $service->id)) }}
                                    </td>
                                    <td style="width: 180px;">
                                        <span data-sales-service-item="{{ $service->id }}" data-sales-service-price="{{ $service->price }}">{{ $service->name }}</span>
                                    </td>
                                    <td style="width: 75px;" class="text-right">
                                        <strong data-sales-service-sub>$ {{ convertIntegerToMoney($service->price) }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <!--tr class="success">
                               <td colspan="3">Total</td>
                               <td class="text-right">
                                   <strong>$689</strong>
                               </td>
                           </tr-->
                            </tfoot>
                        </table>

                    </div>


                </div>
                <!-- END Block -->
            @endif

            @if( empty($appointment))

                <!--div class="block">

            <div class="block-title">
                <h2>Buscador de Clientes</h2>
            </div>
            <div class="">
                <fieldset>

                    {{-- Buscar cliente :  -  TEXT --}}
                    <div class="form-group">
                        <div id="autocomplete-customers">
                            {{ Form::text('q', null, array('class' => 'form-control typeahead', 'placeholder' => 'Nombre, E-mail, Apodo', 'id' => 'q')) }}
                        </div>
                    </div>

                </fieldset>
            </div>

        </div-->

            @endif

        </div>
        {{ Form::close() }}
    </div>
    <!-- END Row -->
@stop