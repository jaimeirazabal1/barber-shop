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
                    <li>{{ link_to_route('app.dashboard', 'Dashboard', $company) }}</li>
                    <li>{{ link_to_route('appointments.index','Citas', $company) }}</li>
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
                <h2>Editar información de la Cita</h2>
                <div class="block-options pull-right">
                    <a href="{{ route('appointments.index', $company) }}" class="btn btn-effect-ripple btn-default" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Volver al listado"><i class="fa fa-chevron-circle-left"></i> Volver al listado</a>
                </div>
            </div>
            <!-- END Horizontal Form Title -->


            <!-- Form Content -->
            {{ Form::model($appointment, array('method' => 'PATCH', 'route' => array('appointments.update', $company, $appointment->id), 'class' => 'form-horizontal form-bordered'))  }}

                @include('appointments.partials._form')

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
                <h2>Agenda</h2>
            </div>
            <!-- END Horizontal Form Title -->


            <div data-single-resource-agenda>
                <div id="calendar">

                </div>
            </div>

        </div>
    </div>
</div>
<!-- END Row -->


@stop


@section('javascript')
<!-- ckeditor.js, load it only in the page you would like to use CKEditor (it's a heavy plugin to include it with the others!) -->
{{ HTML::script('js/plugins/ckeditor/ckeditor.js') }}

<!-- Load and execute javascript code used only in this page -->
{{ HTML::script('js/pages/formsComponents.js') }}
<script>$(function(){ FormsComponents.init(); });</script>


<script type='text/javascript' src="{{ asset('js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

@if( ! empty($appointment->barber_id))


<script type='text/javascript'>


    /*function isOverlap(event)
     {
     console.log('resourceId', event.resourceId);

     var start = new Date(event.start),
     end   = new Date(event.end);

     console.log('start---', Math.round(start)/1000);
     console.log('end---', Math.round(end)/1000);

     var overlap = $('#calendar').fullCalendar('clientEvents', function(ev)
     {
     console.log('clienteEvents', ev);
     if( ev == event)
     {
     console.log('false 1111');
     return false;
     }

     var estart = new Date(ev.start);
     var eend = new Date(ev.end);

     console.log('start ev---', Math.round(estart)/1000);
     console.log('end ev---', Math.round(eend)/1000);

     console.log('Formula', (Math.round(estart)/1000 < Math.round(end)/1000 && Math.round(eend) > Math.round(start)));
     return (Math.round(estart)/1000 < Math.round(end)/1000 && Math.round(eend) > Math.round(start));
     });


     if (overlap.length)
     {
     console.log('trueee 2');
     return false;
     //either move this event to available timeslot or remove it
     }
     }*/




    function revertFunc()
    {
        //console.log('Revert Func');
    }

    $(document).ready(function() {

        var calendar = $('#calendar').fullCalendar({
            header: {
                //left: 'resourceDay',
                left: 'title',
                center: '',
                right: ''
            },
            year: {{ $year }},
            month: {{ $month }},
            date: {{ $day }},
            firstDay: 0,
            editable: true,
            allDaySlot: false,
            height: 650,
            slotMinutes: 30, // http://fullcalendar.io/docs1/agenda/
            sloteventoverlap: false,
            titleFormat: 'MMM dd, yyyy',
            defaultView: 'resourceDay',
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay, event, resourceId) {
                /*var title = prompt('Event Title:');
                 if (title) {
                 console.log("@@ adding event " + title + ", start " + start + ", end " + end + ", allDay " + allDay + ", resource " + resourceId);
                 calendar.fullCalendar('renderEvent',
                 {
                 title: title,
                 start: start,
                 end: end,
                 allDay: allDay,
                 resourceId: resourceId
                 },
                 true // make the event "stick"
                 );
                 }
                 calendar.fullCalendar('unselect');*/
            },
            resources: [
                {
                    name: '{{ $barber->first_name }} {{ $barber->last_name }}',
                    id:	'{{ $barber->uuid }}'
                },
            ],
            /*
             events: {
             url: '/myfeed.php',
             cache: true
             }

             */
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
            events: [
                @foreach($barber->appointments as $appoint)
                {
                    id: {{ $appoint->id }},
                    title: '{{ $appoint->customer->first_name}} {{ $appoint->customer->last_name }}',
                    start: {{ $appoint->start->timestamp }},
                    end: {{ $appoint->end->timestamp }},
                    allDay: false,
                    resourceId: '{{ $barber->uuid }}'
                },
                @endforeach
            ],



            /*    [

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
             ],*/
            timeFormat: 'h:mm{ - h:mm}',
            monthNames: [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ],
            monthNamesShort: [
                'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
            ],
            dayNames : [
                'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'
            ],
            dayNamesShort : [
                'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb', 'Dom'
            ],
            eventMouseover: function(event, jsEvent, view){
                //console.log(event);
            },
            eventClick: function(event, jsEvent, view) {
                /*
                 alert('Event: ' + event.title);
                 alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                 alert('View: ' + view.name);

                 // change the border color just for fun
                 $(this).css('border-color', 'red');
                 */

            },
            dayClick: function(date, allDay, jsEvent, view) {
                /*
                 if (allDay) {
                 alert('Clicked on the entire day: ' + date);
                 }else{
                 alert('Clicked on the slot: ' + date);
                 }

                 alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

                 alert('Current view: ' + view.name);

                 // change the day's background color just for fun
                 $(this).css('background-color', 'red');
                 */

            },
            eventDragStart: function( event, jsEvent, ui, view ) {

            },
            eventDragStop: function( event, jsEvent, ui, view , revertFunc)
            {
                console.log('EventDragStop', event);
                //console.log(isOverlap(event));

            },
            eventDrop: function( event, dayDelta, minuteDelta, allDay) {

                console.log('EventDrop', event);
                //console.log('----', isOverlap(event));

                //console.log("@@ drag/drop event " + event.title + ", start " + event.start + ", end " + event.end + ", resource " + event.resourceId);
            },
            eventResize: function(event, dayDelta, minuteDelta) {
                //console.log("@@ resize event " + event.title + ", start " + event.start + ", end " + event.end + ", resource " + event.resourceId);
            },
            eventResizeStart: function( event, jsEvent, ui, view ) { },
            eventResizeStop: function( event, jsEvent, ui, view ) { }
        });


        //calendar.fullCalendar( 'gotoDate', 2015, 6, 3);

        @if ( ! empty($barber))
        $('#{{ $barber->uuid }}').css('background-color', '{{ $barber->color }}');
        @endif

    });

</script>


@else

    <script type='text/javascript'>

        $(document).ready(function() {

            var calendar = $('#calendar').fullCalendar({
                header: {
                    //left: 'resourceDay',
                    left: 'title',
                    center: '',
                    right: ''
                },
                year: {{ $year }},
                month: {{ $month }},
                date: {{ $day }},
                firstDay: 0,
                editable: true,
                allDaySlot: false,
                height: 650,
                slotMinutes: 30, // http://fullcalendar.io/docs1/agenda/
                sloteventoverlap: false,
                titleFormat: 'MMM dd, yyyy',
                defaultView: 'resourceDay',
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay, event, resourceId) {
                    /*var title = prompt('Event Title:');
                     if (title) {
                     console.log("@@ adding event " + title + ", start " + start + ", end " + end + ", allDay " + allDay + ", resource " + resourceId);
                     calendar.fullCalendar('renderEvent',
                     {
                     title: title,
                     start: start,
                     end: end,
                     allDay: allDay,
                     resourceId: resourceId
                     },
                     true // make the event "stick"
                     );
                     }
                     calendar.fullCalendar('unselect');*/
                },
                resources: [
                    {
                        name: 'Sin asignar',
                        id:	'pending'
                    },
                ],
                /*
                 events: {
                 url: '/myfeed.php',
                 cache: true
                 }

                 */
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
                events: [
                    @foreach($appointments as $appointment)
                    {
                        id: {{ $appointment->id }},
                        title: '{{ $appointment->customer->first_name . ' ' . $appointment->customer->last_name }}',
                        start: {{ $appointment->start->timestamp }},
                        end: {{ $appointment->end->timestamp }},
                        allDay: false,
                        resourceId: 'pending'
                    },
                    @endforeach
                ],



                /*    [

                 {
                 id: 1,
                 title: 'Short Event 1',
                 start: new Date(y, m, d, 11, 30),
                 end: new Date(y, m, d, 13, 00),
                 allDay: false,
                 resourceId: 'resource1'
                 },
                 {
                 id:2,
                 title: 'Short Event 2',
                 start: new Date(y, m, d + 1, 14, 00),
                 end: new Date(y, m, d + 1, 15, 00),
                 allDay: false,
                 resourceId: 'resource1'
                 },

                 {
                 id:3,
                 title: 'Lunch',
                 start: new Date(y, m, d, 12, 0),
                 end: new Date(y, m, d, 14, 0),
                 allDay: false,
                 resourceId: 'resource2'
                 },

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
                 ],*/
                timeFormat: 'h:mm{ - h:mm}',
                monthNames: [
                    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                monthNamesShort: [
                    'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
                ],
                dayNames : [
                    'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'
                ],
                dayNamesShort : [
                    'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb', 'Dom'
                ],
                eventMouseover: function(event, jsEvent, view){
                    //console.log(event);
                },
                eventClick: function(event, jsEvent, view) {
                    /*
                     alert('Event: ' + event.title);
                     alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                     alert('View: ' + view.name);

                     // change the border color just for fun
                     $(this).css('border-color', 'red');
                     */

                },
                dayClick: function(date, allDay, jsEvent, view) {
                    /*
                     if (allDay) {
                     alert('Clicked on the entire day: ' + date);
                     }else{
                     alert('Clicked on the slot: ' + date);
                     }

                     alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

                     alert('Current view: ' + view.name);

                     // change the day's background color just for fun
                     $(this).css('background-color', 'red');
                     */

                },
                eventDragStart: function( event, jsEvent, ui, view ) {

                },
                eventDragStop: function( event, jsEvent, ui, view , revertFunc)
                {
                    console.log('EventDragStop', event);
                    //console.log(isOverlap(event));

                },
                eventDrop: function( event, dayDelta, minuteDelta, allDay) {

                    console.log('EventDrop', event);
                    //console.log('----', isOverlap(event));

                    //console.log("@@ drag/drop event " + event.title + ", start " + event.start + ", end " + event.end + ", resource " + event.resourceId);
                },
                eventResize: function(event, dayDelta, minuteDelta) {
                    //console.log("@@ resize event " + event.title + ", start " + event.start + ", end " + event.end + ", resource " + event.resourceId);
                },
                eventResizeStart: function( event, jsEvent, ui, view ) { },
                eventResizeStop: function( event, jsEvent, ui, view ) { }
            });


            //calendar.fullCalendar( 'gotoDate', 2015, 6, 3);


        });



    </script>

@endif

@stop