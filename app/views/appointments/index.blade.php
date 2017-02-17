@extends('layouts.master')

@section('title', 'Citas')

@section('content')

    <!-- Section Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Citas</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>{{ link_to_route('appointments.index', 'Citas', $company) }}</li>
                        <li>Calendario</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END Section Header -->

    @if ($composer_user->hasAnyAccess(['admin', 'company']))
    <div class="block full">
        <div class="row">
            <div class="col-md-4">
                <select class="select-select2" data-placeholder="Sucursal" style="width: 100%;" id="store_id" data-agenda-store="change">
                @foreach($stores as $storeOption)
                    <option {{ ($storeOption->id === $store->id) ? 'selected' : '' }} value="{{ $storeOption->id }}">{{ $storeOption->name }}</option>
                @endforeach
                </select>

            </div>
            <div class="col-md-8 text-right">
                <div class="col-md-12">
                    <a data-target="#modal-services-search" data-toggle="modal" href="#" class="btn btn-effect-ripple btn-default" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i> Buscar servicios</a>
                    <a data-target="#modal-products-search" data-toggle="modal" href="#" class="btn btn-effect-ripple btn-default" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i> Buscar productos</a>
                </div>
                {{-- Citas disponibles por fecha - DATE PICKER --}}
                <div style="margin-top: 20px;" class="col-md-6 col-md-offset-6 text-right">
                    <small class="label label-default">Ver disponibilidad de citas</small>
                    {{ Form::text('appointments_available', null, array('class' => 'form-control input-datepicker-appointments-available', 'placeholder' => 'yyyy-mm-dd', 'id' => 'appointments_available', 'data-date-format' => 'yyyy-mm-dd', 'readonly' => true)) }}
                </div>

            </div>

        </div>
    </div>
    @endif

    <!-- FullCalendar Block -->
    <div class="block full">

        <!-- Partial Responsive Title -->
        <div class="block-title">
            <h2>Calendario</h2>
            <div class="block-options pull-right">

            </div>
        </div>
        <!-- END Partial Responsive Title -->

        <div class="row">

            <div class="col-md-12 ">

                @if ( count($barbers))
                    <!-- FullCalendar (initialized in js/pages/compCalendar.js), for more info and examples you can check out http://arshaw.com/fullcalendar/ -->
                    <div id="calendar" data-create-start="" data-create-end="" data-create-resourceid="" data-create-allday=""></div>
                @else
                    <p>Esta sucursal no tiene barberos asignados. <a href="" class="btn btn-effect-ripple btn-success btn-sm"><i class="fa fa-plus"></i> Asignar Barberos</a></p>
                @endif

            </div>
        </div>
    </div>
    <!-- END FullCalendar Block -->


    <!-- Modal -->
    <div id="modal-appointments-available" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- END Modal-->

    <!-- Modal -->
    <div id="modal-services-search" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                @include('appointments.modals.services')
            </div>
        </div>
    </div>
    <!-- END Modal-->

    <!-- Modal -->
    <div id="modal-products-search" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                @include('appointments.modals.products')
            </div>
        </div>
    </div>
    <!-- END Modal-->


    <!-- Modal -->
    <div id="modal-master" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                @include('appointments.modals.create')
            </div>
        </div>
    </div>
    <!-- END Modal-->


    <!-- Modal -->
    <div id="modal-master-edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- END Modal-->

    @foreach($barbers as $barber)
    {{ Form::hidden('barber_mealtime_in_' . $barber->id, $barber->mealtime_in) }}
    {{ Form::hidden('barber_mealtime_out_' . $barber->id, $barber->mealtime_out) }}
    {{ Form::hidden('time_barber_mealtime_in_' . $barber->id, \Carbon\Carbon::createFromFormat('H:i:s', $barber->mealtime_in)->format('ga') ) }}
    {{ Form::hidden('time_barber_mealtime_out_' . $barber->id, \Carbon\Carbon::createFromFormat('H:i:s', $barber->mealtime_out)->format('ga') ) }}
    @endforeach

    <a style="display: none;" data-href="{{ route('appointments.index', $company) }}" href="#" data-calendar-event-edit data-toggle="modal" data-backdrop="static" data-target="#modal-master-edit"></a>

    <button style="display: none;" type="button" data-calendar-event-create data-toggle="modal" data-backdrop="static" data-target="#modal-master"></button>


    <a style="display: none;" href="#" data-appointments-available data-toggle="modal" data-backdrop="static" data-target="#modal-appointments-available"></a>
@stop

@section('javascript')


<script type='text/javascript' src="{{ asset('assets/admin/js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
{{ HTML::script('vendors/typeahead.js/typeahead.bundle.js') }}
{{ HTML::script('assets/admin/js/filtertable.js') }}
{{ HTML::script('vendors/handlebars/handlebars.js') }}


<!-- Load and execute javascript code used only in this page -->
{{ HTML::script('assets/admin/js/plugins/datepicker/bootstrap-datepicker.es.js') }}
{{ HTML::script('assets/admin/js/pages/formsComponents.js') }}
<script>$(function(){ FormsComponents.init(); });</script>


<script type='text/javascript'>


    $(document).ready(function() {

        $('.input-datepicker-appointments-available').datepicker({
            weekStart: 1,
            language: 'es'
        }).on('changeDate', function(e){
            $(this).datepicker('hide');

            var date = $(this).val();

            var url = $('body').data('url') + '/appointments/create?store={{ $store->id }}&date=' + date;

            console.log(url);

            $('[data-appointments-available]').prop('href', url);
            $('[data-appointments-available]').trigger('click');
        });

        /********* FILTER TABLE *********/
        // attach table filter plugin to inputs
        $('[data-action="filter"]').filterTable();

        $('.container').on('click', '.panel-heading span.filter', function(e){
            var $this = $(this),
                    $panel = $this.parents('.panel');

            $panel.find('.panel-body').slideToggle();
            if($this.css('display') != 'none') {
                $panel.find('.panel-body input').focus();
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
        /********* FILTER TABLE *********/

        var updateEvent = null;

        window.UI = {};

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


        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'month',
                center: 'title',
                right: 'resourceDay today prev,next'
            },
            firstDay: 1,
            editable: true,
            disableResizing: true,
            allDaySlot: false,
            slotMinutes: 30, // http://fullcalendar.io/docs1/agenda/
            sloteventoverlap: false,
            titleFormat: 'MMM dd, yyyy',
            defaultView: 'resourceDay',
            selectable: true,
            selectHelper: true,
            firstHour: {{ $store_start_appointments->hour }},//0-23, where 0=midnight, 1=1am, etc.
            minTime: '{{ $store_start_appointments->format('g:ia') }}',//This can be a number like 5 (which means 5am), a string like '5:30' (which means 5:30am) or a string like '5:30am'.
            maxTime: '{{ $store_end_appointments->format('g:ia') }}',// This can be a number like 22 (which means 10pm), a string like '22:30' (which means 10:30pm) or a string like '10:30pm'.
            resources: [
                @foreach($barbers as $barber)
                {
                    name: '{{ $barber->first_name }} {{ $barber->last_name }}',
                    id:	'{{ $barber->id }}'
                },
                @endforeach
                {
                    name: 'Sin asignar',
                    id: 'pending'
                }
            ],
            lazyFetching: false,
            loading: function(isLoading, view){
                if(isLoading)
                {
                    $('#page-wrapper').addClass('page-loading');
                }
                else
                {
                    $('#page-wrapper').removeClass('page-loading');
                }
            },
            events: $('body').data('url-api') + 'appointments?limit=1000&store=' + $('#hidden_store_id').val()

                /*
                {
                    id:4,
                    title: 'Click for Google',
                    start: new Date(y, m, d, 16, 0),
                    end: new Date(y, m, d, 16, 30),
                    allDay: false,
                    url: 'http://google.com/',
                    resourceId: 'resource3'/*,
                    className: '',
                    editable: false, // Solo es editadable si el estatus es diferente de confirmado
                    color: '',
                    backgroundColor: '',
                    borderColor: '',
                    textColor: '',

                }
            ]*/,
            timeFormat: 'h:mm{ - h:mm}',
            monthNames: [
                    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ],
            monthNamesShort: [
                    'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
            ],
            dayNames : [
                'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado',
            ],
            dayNamesShort : [
                'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb',
            ],
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                resourceDay: 'Barbero'
            },
            /**
             * Crea la cita
             *
             * */
              select: function(start, end, allDay, event, resourceId) {
                var view = $('#calendar').fullCalendar('getView');
                // create a new javascript Date object based on the timestamp
                // multiplied by 1000 so that the argument is in milliseconds, not seconds
                var date = new Date(start);
                // hours part from the timestamp
                var date_start = new Date(start),
                        date_end = new Date(end),
                        date_start_moment = moment(date_start),
                        date_end_moment = moment(date_end);

                //alert(date_start_moment.format('YYYY-MM-DD HH:mm:ss'));
                //alert(date_end_moment.format('YYYY-MM-DD HH:mm:ss'));


                if (view.name == 'resourceDay')
                {
                    // datos temporales para la nueva cita
                    $('#calendar').data('create-start', start);
                    $('#calendar').data('create-end', end);
                    $('#calendar').data('create-resourceid', resourceId);
                    $('#calendar').data('create-allday', allDay);

                    $('#barber_id').val(resourceId).trigger('change');

                    var appointmentDate = moment(calendar.fullCalendar('getDate')).format('YYYY-MM-DD');

                    var barber_mealtime_in = moment(calendar.fullCalendar('getDate')).format('YYYY-MM-DD') + ' ' + $('[name="barber_mealtime_in_' + resourceId + '"]').val(),
                        barber_mealtime_out = moment(calendar.fullCalendar('getDate')).format('YYYY-MM-DD') + ' ' + $('[name="barber_mealtime_out_' + resourceId + '"]').val();

                    //alert(barber_mealtime_in);
                    //alert(barber_mealtime_out);

                    var barber_moment_mealtime_in  = moment(barber_mealtime_in, 'YYYY-MM-DD HH:mm:ss'),
                        barber_moment_mealtime_out = moment(barber_mealtime_out, 'YYYY-MM-DD HH:mm:ss');


                    var can1 = moment(date_start_moment.format('YYYY-MM-DD HH:mm:ss')).isBetween(barber_moment_mealtime_in.format('YYYY-MM-DD HH:mm:ss'), barber_moment_mealtime_out.format('YYYY-MM-DD HH:mm:ss'));
                    var can2 = moment(date_end_moment.format('YYYY-MM-DD HH:mm:ss')).isBetween(barber_moment_mealtime_in.format('YYYY-MM-DD HH:mm:ss'), barber_moment_mealtime_out.format('YYYY-MM-DD HH:mm:ss'));
                    var isSame1 = moment(date_start_moment.format('YYYY-MM-DD HH:mm:ss')).isSame(barber_moment_mealtime_in.format('YYYY-MM-DD HH:mm:ss'));
                    var isSame2 = moment(date_end_moment.format('YYYY-MM-DD HH:mm:ss')).isSame(barber_moment_mealtime_out.format('YYYY-MM-DD HH:mm:ss'));

                    //console.log('moment mealtime in', barber_moment_mealtime_in.toString());
                    //console.log('moment mealtime out', barber_moment_mealtime_out.toString());


                    $('#appointment-date').val(appointmentDate);

                    $('#start').timepicker('setTime', start);
                    $('#end').timepicker('setTime', end);


                    if((can1 == false && can2 == false) && (isSame1 == false && isSame2 == false))
                    {
                        $('[data-calendar-event-create]').trigger('click');
                    }
                    else
                    {
                        var n = noty({
                            text: '<i class="fa fa-times"></i> La cita no puede agendarse en el horario de comida.',
                            animation: {
                                open: 'animated bounceInLeft', // Animate.css class names
                                close: 'animated bounceOutLeft', // Animate.css class names
                                easing: 'swing', // unavailable - no need
                                speed: 500 // unavailable - no need
                            },
                            type: 'error'
                        });
                    }


                }
                else if (view.name == 'month')
                {
                    $('#calendar').fullCalendar('gotoDate', date.getFullYear(), date.getMonth(), date.getDate());
                    $('#calendar').fullCalendar('changeView', 'resourceDay');
                }



            },
            eventMouseover: function(event, jsEvent, view) {
                //$('.fc-event-inner', this).append('<div id=\"'+event.id+'\" class=\"hover-end\">'+$.fullCalendar.formatDate(event.end, 'h:mmt')+'</div>');
            },

            eventMouseout: function(event, jsEvent, view) {
                //$('#'+event.id).remove();
            },
            eventRender: function(event, element, view) {
               console.log(event)
            },
            eventAfterRender: function(event, element){
                var services = ['<ul class="text-left">'];

                for(var i = 0; i < event.services.length; i++)
                {
                    services.push('<li>');
                    services.push(event.services[i].name);
                    services.push('</li>');
                }

                services.push('</ul>')
                services = services.join('');

                //console.log('events', event);

                var phone = event.customer.phone || 'No disponible';
                var cellphone = event.customer.cellphone || 'No disponible';

                /*$(element).tooltip({
                    title: '<p class="text-left" style="margin-bottom: 10px; padding-bottom: 0;">' + event.title + '<br>' + '<small>Estatus: ' + event.status_text + '</small>' +  '</p>' + services,
                    container: 'body',
                    placement: 'top',
                    html: true
                });*/
                $(element).popover({
                    title: '<p class="text-left" style="margin-bottom: 10px; padding-bottom: 0;">' + event.title + '<br><small style="font-size: 0.8em;">Teléfono: ' + phone + '</small><br />' + '<small style="font-size: 0.8em;">Celular: ' + cellphone + '</small><br />' + '<small style="font-size: 0.8em;">Estatus: ' + event.status_text + '</small>' +  '</p>' + services,
                    container: 'body',
                    trigger: 'hover',
                    placement: 'top',
                    html: true
                });
            },
            eventClick: function(event, jsEvent, view) {

                var d = new Date();
                var n = d.getTime();

                var $modal = $('[data-calendar-event-edit]');

                var href  = $modal.data('href') + '/' + event.id + '/edit?time=' + n + '&store=' + $('#hidden_store_id').val();

                $modal.prop('href', href);

                $modal.trigger('click');

                updateEvent = event;

            },
            /*eventDragStop: function (event, delta, revertFunc, ev) {
                event._srcResourceId = event.resourceId;
            },*/
            /**
             * Actualiza la hora y barbero de la cita
            */
            eventDrop: function( event, dayDelta, minuteDelta, allDay, revertFunc) {
                var startMoment = moment(event.start),
                    endMoment   = moment(event.end);

                var data = {
                    start: startMoment.format('YYYY-MM-DD HH:mm:ss'),
                    end: endMoment.format('YYYY-MM-DD HH:mm:ss'),
                    barber: {
                        id: event.resourceId
                    }
                };
              

                /*console.log('drag event', event);
                console.log('drag data', data);*/


                $.blockUI({ message: '<p style="padding-top: 10px;" class="text-muted"><i class="fa fa-cog fa-spin"></i> actualizando cita...</p>' });
                console.log($('body').data('url-api') + 'appointments/' + event.id + '?start=' + data.start + '&end=' + data.end+"&barber_id="+data.barber.id)
                $.ajax({
                    url: $('body').data('url-api') + 'appointments/' + event.id + '?start=' + data.start + '&end=' + data.end+"&barber_id="+data.barber.id,
                    dataType: 'json',
                    type: 'PUT',
                    data: JSON.stringify(data),
                    success: function(response){

                        var n = noty({
                            text: '<i class="fa fa-check"></i> Cita actualizada correctamente.',
                            animation: {
                                open: 'animated bounceInLeft', // Animate.css class names
                                close: 'animated bounceOutLeft', // Animate.css class names
                                easing: 'swing', // unavailable - no need
                                speed: 500 // unavailable - no need
                            }
                        });

                    },
                    error: function(xhr, textStatus, error){
                        console.log(error)
                        event.resourceId = event.oldResourceId;

                        revertFunc();

                        var error = xhr.responseJSON.error.message || 'Ocurrió un error al actualizar la cita, intente nuevamente por favor.';

                        var n = noty({
                            text: '<i class="fa fa-warning"></i> ' + error,
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
                        $.unblockUI();
                        $(document).find('.popover').remove();
                    }
                });
            },
            eventRender: function(event, element) {

                //console.log('eventRender');
                /*console.log('qtip', element);
                element.qtip(
                        {
                        //content: event.description
                        content: {
                            title: {
                                button: true,
                                text: event.title
                            }
                            //text: '<p>' + (event.customer.aka == undefined ? '' : event.customer.aka + '<br />')  + event.customer.email + '<br>Tel. ' + event.customer.phone + '<br>Cel. ' + event.customer.cellphone + '</p><p>SERVICIOS:<br/>' + event.services + '</p><p><a class="btn btn-xs btn-primary" href="' + $('body').data('url') + '/appointments/' + event.uuid + '/edit"><i class="fa fa-pencil"></i> Editar cita</a></p>'
                        },
                        hide : {
                            event: false
                        },
                        position: {
                            my: 'bottom center',
                            at: 'top center'
                        },

                        //hide: { when: 'inactive', delay: 3000 },
                        style: 'qtip-light'
                    }
                );*/
            }
        });


        @foreach($barbers as $barber)
            $('#{{ $barber->id }}').css('background-color', '{{ $barber->color }}');
        @endforeach


        function getAppointmentServices()
        {
            var $select = $('#services'),
                    values = $select.val() || null,
                    services = [];

            if ( ! values)
            {
                return [];
            }


            for(var i = 0; i < values.length; i++)
            {
                var id   = values[i],
                    time = $select.find('option[value="' + id + '"]').data('time');

                services.push({
                    service: {
                        id: id
                    },
                    estimated_time: time
                })
            }

            return services;

        }

        function getAppointmentServicesEdit()
        {
            var $select = $('[data-appointment-services-edit]'),
                    values = $select.val() || null,
                    services = [];

            if ( ! values)
            {
                return [];
            }


            for(var i = 0; i < values.length; i++)
            {
                var id   = values[i],
                        time = $select.find('option[value="' + id + '"]').data('time');

                services.push({
                    service: {
                        id: id
                    },
                    estimated_time: time
                })
            }

            return services;

        }


        /**
         * APPOINTMENTS
         */

        /**
         * Cancela la cita
         */

        $(document).on('submit', '[data-cancel-appointment]', function(e)
        {
            e.preventDefault();

            var $form = $(this),
                    $submitButton = $form.find('[type="submit"]');


            if( confirm('La cita será cancelada. ¿Deseas continuar?'))
            {
                $submitButton.prop('disabled', true);
                $submitButton.html('<i class="fa fa-cog fa-spinner"></i> Cancelando cita..');

                $.ajax({
                    url: $form.prop('action'),
                    dataType: 'json',
                    type: 'DELETE',
                    success: function(response){

                        var n = noty({
                            text: '<i class="fa fa-check"></i> La cita se ha cancelado correctamente.',
                            animation: {
                                open: 'animated bounceInLeft', // Animate.css class names
                                close: 'animated bounceOutLeft', // Animate.css class names
                                easing: 'swing', // unavailable - no need
                                speed: 500 // unavailable - no need
                            }
                        });

                        $('#modal-master-edit').modal('hide');


                        if( response.data)
                        {
                            calendar.fullCalendar('removeEvents', response.data.id);
                        }
                    },
                    error: function(xhr, textStatus, error){

                        var msg = 'Ocurrió un error al cancelar la cita, intente nuevamente por favor.',
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
                        $submitButton.prop('disabled', false);
                        $submitButton.html('Cancelar cita');
                    }
                });
            }

        });

        /**
         * Editar la cita
         */
        $(document).on('submit', '[data-appointment-edit]', function(e)
        {
            e.preventDefault();

            // obtiene los valores temporales de la cita seleccionada

            var $status      = $('#status_edit');

            var $form = $(this),
                    $submitButton = $form.find('[type="submit"]');

            /********/
            var     date       = $('[data-appointment-date-edit]').val(),
                    start      = date + ' ' + $('[data-appointment-start-edit]').val(),
                    end        = date + ' ' + $('[data-appointment-end-edit]').val();


            var startMoment = moment(start, 'YYYY-MM-DD H:m A'),
                    endMoment   = moment(end, 'YYYY-MM-DD H:m A');

            /********/

            var data = {
                start: startMoment.format('YYYY-MM-DD HH:mm:ss'),
                end: endMoment.format('YYYY-MM-DD HH:mm:ss'),
                services: getAppointmentServicesEdit(),
                status: $status.val()
            };

            //console.log('Edit:event:data', data);

            $submitButton.prop('disabled', true);
            $submitButton.html('<i class="fa fa-cog fa-spinner"></i> Actualizando cita..');

            $.ajax({
                url: $form.prop('action'),
                dataType: 'json',
                type: 'PUT',
                data: JSON.stringify(data),
                success: function(response){

                    var n = noty({
                        text: '<i class="fa fa-check"></i> La cita se ha actualizado correctamente.',
                        animation: {
                            open: 'animated bounceInLeft', // Animate.css class names
                            close: 'animated bounceOutLeft', // Animate.css class names
                            easing: 'swing', // unavailable - no need
                            speed: 500 // unavailable - no need
                        }
                    });


                    //$('#modal-master-edit').modal('hide');


                    if( response.data)
                    {
                        // TODO : actualizar cita con los datos modificados
                        //$('#calendar').fullCalendar( 'refetchEvents' );
                        updateEvent.start = response.data.start;
                        updateEvent.end = response.data.end;
                        updateEvent.status = response.data.status;
                        updateEvent.status_text = response.data.status_text;
                        updateEvent.services = response.data.services;

                        $('#calendar').fullCalendar('updateEvent', updateEvent);

                    }
                },
                error: function(xhr, textStatus, error){

                    var msg = 'Ocurrió un error al actualizar la cita, intente nuevamente por favor.',
                            errors = xhr.responseJSON.error.message || {};

                    switch(xhr.status)
                    {
                        case 400:
                            msg = 'Por favor verifique la información.<br /><br />';

                            if (errors)
                            {
                                msg += '<ul>';
                                for (var key in errors)
                                {
                                    if (errors.hasOwnProperty(key))
                                    {
                                        msg += '<li>' + errors[key] + '</li>';
                                    }
                                }
                                msg += '</ul>';
                            }

                            break;
                        case 500:
                            msg = 'Ocurrió un error al actualizar la cita:<br /><br />' + errors;
                            break;
                    }

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
                    $submitButton.prop('disabled', false);
                    $submitButton.html('Actualizar cita');
                }
            });
        });


        /**
         *
         * Crea una cita
         *
         */
        $(document).on('submit','[data-appointment-create]', function(e)
        {
            e.preventDefault();

            // obtiene los valores temporales de la cita seleccionada
            var     date       = $('#appointment-date').val(),
                    start      = date + ' ' + $('#start').val(),
                    end        = date + ' ' + $('#end').val(),
                    resourceId = $('#calendar').data('create-resourceid'),
                    allDay     = $('#calendar').data('create-allday'),
                    notify_by_email = $('#customer_notification_email').is(':checked'),
                    notify_by_cellphone = $('#customer_notification_cellphone').is(':checked');

            var startMoment = moment(start, 'YYYY-MM-DD H:m A'),
                    endMoment   = moment(end, 'YYYY-MM-DD H:m A');

            var $customer_name   = $('#customer_name')
                    customer_name = $customer_name.val(),
                    $customer_id = $('#customer_id'),
                    $store_id    = $('#hidden_store_id'),
                    $status      = $('#status');

            var $form = $(this),
                    $submitButton = $form.find('[type="submit"]'),
                    appointmentServices = getAppointmentServices();

            var data = {
                start: startMoment.format('YYYY-MM-DD HH:mm:ss'),
                end: endMoment.format('YYYY-MM-DD HH:mm:ss'),
                status: $status.val(),
                title: $customer_name.val(),
                allDay: false,
                customer: {
                    id: $customer_id.val()
                },
                store: {
                    id: $store_id.val()
                },
                barber: {
                    id: resourceId || null
                },
                // TODO : Agregar servicios
                services: appointmentServices,
                notify_by_email: Boolean(notify_by_email),
                notify_by_cellphone: Boolean(notify_by_cellphone)
            };

            $submitButton.prop('disabled', true);
            $submitButton.html('<i class="fa fa-cog fa-spinner"></i> Guardando..');

            $.ajax({
                url: $('body').data('url-api') + 'appointments',
                dataType: 'json',
                type: 'POST',
                data: JSON.stringify(data),
                success: function(response){
                    //console.log('responsessss', response);

                    var n = noty({
                        text: '<i class="fa fa-check"></i> La cita se ha registrado correctamente.',
                        animation: {
                            open: 'animated bounceInLeft', // Animate.css class names
                            close: 'animated bounceOutLeft', // Animate.css class names
                            easing: 'swing', // unavailable - no need
                            speed: 500 // unavailable - no need
                        }
                    });

                    $('#services').val(null).trigger('change');


                    $('#modal-master').modal('hide');

                    $form.get(0).reset();

                    if( response.data)
                    {
                        calendar.fullCalendar('renderEvent', {
                            title: customer_name,
                            start: start,
                            end: end,
                            allDay: allDay,
                            id: response.data.id,
                            resourceId: resourceId,
                            services: response.data.services,
                            appointment: response.data,
                            status_text: response.data.status_text,
                            customer: response.data.customer
                        }, true);

                        // TODO : Al crear la cita ver que el popover funcione correctamente



                        calendar.fullCalendar('unselect');
                    }
                },
                error: function(xhr, textStatus, error){

                    console.log(xhr);
                    console.log(textStatus);
                    console.log(error);

                    var msg = 'Ocurrió un error al registrar la cita, intente nuevamente por favor.',
                            errors = xhr.responseJSON.error.message || {};

                    switch(xhr.status)
                    {
                        case 400:
                            msg = 'Por favor verifique la información.<br /><br />';

                            if (errors)
                            {
                                msg += '<ul>';
                                for (var key in errors)
                                {
                                    if (errors.hasOwnProperty(key))
                                    {
                                        msg += '<li>' + errors[key] + '</li>';
                                    }
                                }
                                msg += '</ul>';
                            }

                            break;
                        case 500:
                            msg = 'Ocurrió un error al registrar la cita:<br /><br /><strong>' + errors + '</strong>';
                            break;
                    }

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
                    $submitButton.prop('disabled', false);
                    $submitButton.html('Agendar cita');
                    $('[name="q"]').val('');
                }
            });
        });

        /**
         * Cancela el registro de una cita nueva
         */
        $(document).on('click', '[data-appointment-cancel-new]', function(e)
        {
            e.preventDefault();

            $('#services').val(null).trigger('change');
            $('[name="q"]').val('');
            $('[data-appointment-create]').get(0).reset();

            calendar.fullCalendar('unselect');

            //console.log('cancelando cita nueva...');
        });


        /**
         * Calcula el tiempo de la cita
         */
        $(document).on('change', '#services', function(e)
        {
            var $select = $(this),
                    values = $select.val() || null
                    minutes = 0;

            if (values)
            {
                for(var i = 0; i < values.length; i++)
                {
                    var id =values[i],
                            time = $select.find('option[value="' + id + '"]').data('time');

                    minutes += time;
                }

                var end       = $('#start').val();
                var endMoment = moment(end, 'HH:mm A');

                endMoment = endMoment.add(minutes, 'minutes');

                //$('#end').timepicker('setTime', endMoment.format('H:mm A'));
                $('#end').timepicker('setTime', endMoment.toDate());
            }
        });

        /**
         * CUSTOMERS - Agregar cliente
         */
        $('[data-customer-create]').on('submit', function(e)
        {
            e.preventDefault();

            var $form = $(this),
                    $first_name  = $('#first_name'),
                    $last_name   = $('#last_name'),
                    $aka         = $('#aka'),
                    $birth_day   = $('#birth_day'),
                    $birth_month = $('#birth_month'),
                    $birth_year  = $('#birth_year'),
                    $email       = $('#email'),
                    $phone       = $('#phone'),
                    $cellphone   = $('#cellphone'),
                    $cellphone_formatted   = $('#cellphone_formatted'),
                    $send_cellphone_notifications = $('[name="send_cellphone_notifications"]'),
                    $mail_notification = $('[name="send_email_notifications"]'),
                    $create_user_account = $('[name="create_user_account"]'),
                    $notes       = $('#notes'),
                    $barber      = $('#barber_customer_id'),
                    $company     = $('#company_id'),
                    $birthdate   = null,
                    $submitButton = $form.find('[type="submit"]');

            $birth_day   = $birth_day.val() || null;
            $birth_month = $birth_month.val() || null;
            $birth_year  = $birth_year.val() || null;

            if ( $birth_day && $birth_month && $birth_year)
            {
                $birth_day   = ($birth_day < 9) ? ('0' + $birth_day) : $birth_day;
                $birth_month = ($birth_month < 9) ? ('0' + $birth_month) : $birth_month;
                $birthdate   = $birth_year + '-' + $birth_month + '-' + $birth_day + ' 00:00:00';
            }



            var data = {
                first_name : $first_name.val(),
                last_name: $last_name.val(),
                aka: $aka.val(),
                email: $email.val(),
                phone: $phone.val(),
                cellphone: $cellphone.val(),
                notes: $notes.val(),
                birthdate: $birthdate,
                cellphone_formatted: $cellphone_formatted.val(),
                send_cellphone_notifications: $send_cellphone_notifications.val(),
                send_email_notifications: $mail_notification.val(),
                create_user_account: $create_user_account.is(':checked'),
                barber: {
                    id: $barber.val()
                },
                company: {
                    id: $company.val()
                }
            };

            $submitButton.prop('disabled', true);
            $submitButton.html('<i class="fa fa-spinner fa-cog"></i> Guardando..');

            $.ajax({
                url: $('body').data('url-api') + 'customers',
                dataType: 'json',
                type: 'POST',
                data: JSON.stringify(data),
                success: function(response){

                    var n = noty({
                        text: '<i class="fa fa-check"></i> Cliente registrado correctamente.',
                        animation: {
                            open: 'animated bounceInLeft', // Animate.css class names
                            close: 'animated bounceOutLeft', // Animate.css class names
                            easing: 'swing', // unavailable - no need
                            speed: 500 // unavailable - no need
                        }
                    });

                    $form.get(0).reset();

                    $('[data-email-extra-data], [data-phone-extra-data]').hide();
                    $('[data-cellphone-preview]').text('');

                    if( response.data)
                    {
                        var aka = response.data.aka || '-',
                                name = response.data.first_name + ' ' + (response.data.last_name ? response.data.last_name : '');
                        $('#customer_name').val(name);
                        $('#customer_aka').val(aka);
                        $('#customer_id').val(response.data.id);
                    }

                },
                error: function(xhr, textStatus, error){

                    //console.log(xhr);

                    var msg = 'Ocurrió un error al registrar al cliente, intente nuevamente por favor.',
                            errors = xhr.responseJSON.error.message || {};

                    switch(xhr.status)
                    {
                        case 400:
                                msg = 'Por favor verifique la información.<br /><br />';

                                if (errors)
                                {
                                    msg += '<ul>';
                                    for (var key in errors)
                                    {
                                        if (errors.hasOwnProperty(key))
                                        {
                                            msg += '<li>' + errors[key] + '</li>';
                                        }
                                    }
                                    msg += '</ul>';
                                }

                            break;
                        case 500:
                                msg = 'Ocurrió un error al registrar al cliente, intente nuevamente por favor.';
                            break;
                    }

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
                    $submitButton.prop('disabled', false);
                    $submitButton.html('Guardar');
                }
            });


        });


        /**
         * UI
         */
        UI = {
            typeahead : $('#autocomplete-customers .typeahead'),
            init: function()
            {
                //this.initBootstrapComponents();
            },
            initBootstrapComponents: function()
            {
                $('[data-toggle="tooltip"]').tooltip();

                $('body').on('hidden.bs.modal', '.modal', function () {
                    $(this).removeData('bs.modal');
                });
            }
        };

        if ( $('#autocomplete-customers').length )
        {
            var engineCustomers = new Bloodhound({
                datumTokenizer: function (datum) {
                    return Bloodhound.tokenizers.whitespace(datum.name);
                },
                //datumTokenizer: Bloodhound.tokenizers.whitespace,
                identify: function(obj) {
                    return obj.id;
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    limit: 10,
                    cache: false,
                    url: $('body').data('url-api') + 'customers?filter=%QUERY&company=' + $('#company_id').val() + '&limit=1000&time=' + Math.floor(Date.now() / 1000),
                    wildcard : '%QUERY',
                    filter: function (customers) {

                        return $.map(customers.data, function (customer) {

                            return {
                                id: customer.id,
                                name: (customer.first_name + ' ' + customer.last_name),
                                first_name: customer.first_name,
                                last_name: customer.last_name,
                                aka: customer.aka,
                                email: customer.email,
                                cellphone: customer.cellphone
                            };
                        });
                    }
                }
            });

            engineCustomers.initialize();


            UI.typeahead.typeahead(
                    {
                        minLength: 3,
                        highlight: true,
                        limit: 20,
                    },
                    {
                        name: 'customers-dataset',
                        displayKey: 'first_name',
                        limit: 20,
                        source: engineCustomers.ttAdapter(),
                        templates: {
                            empty: [
                                '<div class="empty-message">',
                                '<p><span class="text-muted">No se encontraron resultados.</span></p>',
                                '</div>'
                            ].join('\n'),
                            suggestion: Handlebars.compile('<p><strong>@{{name}}</strong><br />@{{#if email}}<small><span class="text-muted">E-mail: </span><span>@{{email}}</span></small><br />@{{/if}}@{{#if aka}}<small><span class="text-muted">Apodo: </span><span>@{{aka}}</span></small>@{{/if}}</p>')
                        }
                    }
            );

            UI.typeahead.on('typeahead:selected', function(eventObject, customer, suggestionDataset)
            {

                if (customer.email || customer.cellphone)
                {
                    $('[data-send-notification]').show();
                }
                else
                {
                    $('[data-send-notification]').hide();
                }

                $('#customer_name').val(customer.name);
                $('#customer_id').val(customer.id);
                $('#customer_aka').val(customer.aka || '-');

                if ( customer.email)
                {
                    $('[data-send-email-notification]').show();
                }
                else
                {
                    $('[data-send-email-notification]').hide();
                }

                if ( customer.cellphone)
                {
                    $('[data-send-sms-notification]').show();
                }
                else
                {
                    $('[data-send-sms-notification]').hide();
                }
            });
        }

        $(window).on('load', function()
        {
            UI.init();
        });

    });

</script>
@stop
