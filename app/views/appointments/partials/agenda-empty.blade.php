<div id="calendar">

</div>

<script type='text/javascript' src="{{ asset('js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
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