{{-- Nombre -  TEXT --}}
<div class="form-group {{ $errors->first('name') ? 'has-error' : '' }}">

    {{ Form::label('name', 'Nombre', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'name')) }}
        @if( $errors->first('name'))
            <p class="help-block">{{ $errors->first('name')  }}</p>
        @endif

        @if ( ! empty($store))
        <p>
            <a class="btn btn-info btn-xs" target="_blank" href="{{ route('app.timeclock.create', [$company, $store->slug]) }}"><i class="fa fa-clock-o"></i> Abrir checador</a>
        </p>
        @endif
    </div>
</div>



{{-- Dirección -  TEXTAREA --}}
<div class="form-group {{ $errors->first('address')? 'has-error' : '' }}">

    {{ Form::label('address', 'Dirección', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::textarea('address', null, array('class' => 'form-control', 'rows' => 7,  'placeholder' => '', 'id' => 'address')) }}
        @if( $errors->first('address'))
            <span class="help-block">{{ $errors->first('address')  }}</span>
        @endif

        <br />
        {{ Form::text('formatted_address', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'formatted_address', 'readonly' => true, 'data-geo' => 'formatted_address')) }}
    </div>
</div>



{{-- Teléfono -  TEXT --}}
<div class="form-group {{ $errors->first('phone') ? 'has-error' : '' }}">

    {{ Form::label('phone', 'Teléfono', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'phone')) }}
        @if( $errors->first('phone'))
            <p class="help-block">{{ $errors->first('phone')  }}</p>
        @endif
    </div>
</div>


{{-- Correo electrónico -  TEXT --}}
<div class="form-group {{ $errors->first('email') ? 'has-error' : '' }}">

    {{ Form::label('email', 'Correo electrónico', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'email')) }}
        @if( $errors->first('email'))
            <p class="help-block">{{ $errors->first('email')  }}</p>
        @endif
    </div>
</div>

@if ($composer_user->hasAnyAccess(['company', 'admin']))
    
    {{-- Administrador de la sucursal -  SELECT2 --}}
    <div class="form-group {{ $errors->first('user_id') ? 'has-error' : '' }}">
    
        {{ Form::label('user_id', 'Administrador de la sucursal', array('class' => 'col-md-4 control-label'))  }}
        <div class="col-md-5">
            {{ Form::select('user_id', $users, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Administrador de sucursal', 'style' => 'width: 100%;', 'id' => 'user_id')) }}
            
            @if( $errors->first('user_id'))
                <span class="help-block">{{ $errors->first('user_id')  }}</span>
            @endif
            
        </div>
    </div>
    
@endif



{{ Form::hidden('lat', null, array('data-geo' => 'lat')) }}

{{ Form::hidden('lng', null, array('data-geo' => 'lng')) }}


@if ($composer_user->hasAnyAccess(['company', 'admin']))

    {{-- Es matriz -  SWITCH --}}
    <div class="form-group {{ $errors->first('is_matrix') ? 'has-error' : '' }}">

        {{ Form::label('is_matrix', 'Es matriz', array('class' => 'col-md-4 control-label'))  }}
        <div class="col-md-8">
            <label class="switch switch-success">{{ Form::checkbox('is_matrix', 'true') }}<span></span></label>


            @if( $errors->first('is_matrix'))
                <span class="help-block">{{ $errors->first('is_matrix')  }}</span>
            @endif
        </div>
    </div>

    {{-- Activo / Inactivo -  SWITCH --}}
    <div class="form-group {{ $errors->first('active') ? 'has-error' : '' }}">

        {{ Form::label('active', 'Inactivo / Activo', array('class' => 'col-md-4 control-label'))  }}
        <div class="col-md-8">
            <label class="switch switch-success">{{ Form::checkbox('active', 'true') }}<span></span></label>


            @if( $errors->first('active'))
                <span class="help-block">{{ $errors->first('active')  }}</span>
            @endif
        </div>
    </div>
@endif


<fieldset>


    <legend>Horario para Citas</legend>

    {{--  Hora de Inicio - TIME --}}
    <div class="form-group {{ $errors->first('start_appointments') ? 'has-error' : '' }}">
        <label class="col-md-4 control-label" for="start_appointments">Hora de Inicio</label>
        <div class="col-md-5">
            <div class="input-group bootstrap-timepicker">
                {{ Form::text('start_appointments', empty($start_appointments) ? null : $start_appointments, array('class' => 'form-control input-timepicker', 'id' => 'start_appointments', 'readonly' => true)) }}
                <span class="input-group-btn">
                    <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                </span>
            </div>
            @if( $errors->first('start_appointments'))
                <p class="help-block">{{ $errors->first('start_appointments') }}</p>
            @endif
        </div>
    </div>


    {{--  Hora de fin - TIME --}}
    <div class="form-group {{ $errors->first('end_appointments') ? 'has-error' : '' }}">
        <label class="col-md-4 control-label" for="end_appointments">Hora de fin</label>
        <div class="col-md-5">
            <div class="input-group bootstrap-timepicker">
                {{ Form::text('end_appointments', empty($end_appointments) ? null : $end_appointments, array('class' => 'form-control input-timepicker', 'id' => 'end_appointments', 'readonly' => true)) }}
                <span class="input-group-btn">
                    <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                </span>
            </div>
            @if( $errors->first('end_appointments'))
                <p class="help-block">{{ $errors->first('end_appointments') }}</p>
            @endif
        </div>
    </div>


    @if ($composer_user->hasAnyAccess(['company', 'admin']))
    <legend>Horarios de Sucursal</legend>

    @foreach($days as $dayKey => $day)

    {{-- Lunes -  SWITCH --}}
    <div class="form-group {{ $errors->first('schedules[day]') ? 'has-error' : '' }}">

        {{ Form::label('schedules[day]', $day, array('class' => 'col-md-4 control-label'))  }}

        <div class="col-md-8">
            <label class="switch switch-info">{{ Form::checkbox('schedules[' . $dayKey . '][day]', 'true', ( ! empty($daysSchedule) and array_key_exists($dayKey, $daysSchedule)) ? true : null, ['data-schedule' => $dayKey]) }}<span></span></label>

            <div data-schedule-info="{{ $dayKey }}" {{ ( ! empty($daysSchedule) and array_key_exists($dayKey, $daysSchedule)) ? '' : ' style="display: none;"' }}>
                <div class="col-md-12" style="margin-top: 20px;">
                    {{ Form::label('opening', 'Sucursal:', array('class' => 'col-md-12 control-label', 'style' => 'text-align: left;'))  }}

                    <div class="col-md-5">
                        <div class="input-group bootstrap-timepicker">
                            {{ Form::text('schedules[' . $dayKey . '][opening]', (empty($daysSchedule[$dayKey]['opening']) ? null : $daysSchedule[$dayKey]['opening']), array('class' => 'form-control input-timepicker', 'id' => '', 'readonly' => true)) }}
                            <span class="input-group-btn">
                                <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        -
                    </div>
                    <div class="col-md-5">
                        <div class="input-group bootstrap-timepicker">
                            {{ Form::text('schedules[' . $dayKey . '][closing]', (empty($daysSchedule[$dayKey]['closing']) ? null : $daysSchedule[$dayKey]['closing']), array('class' => 'form-control input-timepicker', 'id' => '', 'readonly' => true)) }}
                            <span class="input-group-btn">
                                <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                            </span>
                        </div>
                    </div>
                </div>

                <!--div class="col-md-12" style="margin-top: 20px;">
                    {{ Form::label('opening', 'Citas:', array('class' => 'col-md-12 control-label', 'style' => 'text-align: left;'))  }}
                    <div class="col-md-5">
                        <div class="input-group bootstrap-timepicker">
                            {{ Form::text('schedules[' . $dayKey . '][opening_appointments]', (empty($daysSchedule[$dayKey]['opening_appointments']) ? null : $daysSchedule[$dayKey]['opening_appointments']), array('class' => 'form-control input-timepicker', 'id' => '', 'readonly' => true)) }}
                            <span class="input-group-btn">
                                <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        -
                    </div>
                    <div class="col-md-5">
                        <div class="input-group bootstrap-timepicker">
                            {{ Form::text('schedules[' . $dayKey . '][closing_appointments]', (empty($daysSchedule[$dayKey]['closing_appointments']) ? null : $daysSchedule[$dayKey]['closing_appointments']), array('class' => 'form-control input-timepicker', 'id' => '', 'readonly' => true)) }}
                            <span class="input-group-btn">
                                <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                            </span>
                        </div>
                    </div>
                </div-->

                <div class="col-md-12" style="margin-top: 20px;">
                    {{ Form::label('opening', 'Entrada de empleados:', array('class' => 'col-md-12 control-label', 'style' => 'text-align: left;'))  }}
                    <div class="col-md-5">
                        <div class="input-group bootstrap-timepicker">
                            {{ Form::text('schedules[' . $dayKey . '][checkin_limit]', (empty($daysSchedule[$dayKey]['checkin_limit']) ? null : $daysSchedule[$dayKey]['checkin_limit']), array('class' => 'form-control input-timepickermin', 'id' => '', 'readonly' => true)) }}
                            <span class="input-group-btn">
                                <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @endif

</fieldset>

<br /><br />


{{-- FORM ACTIONS --}}
<div class="form-group form-actions">
    <div class="col-md-8 col-md-offset-4">
        {{ Form::submit('Guardar', array('class' => 'btn btn-effect-ripple btn-primary')) }}
        {{ Form::reset('Limpiar formulario', array('class' => 'btn btn-effect-ripple btn-danger')) }}
    </div>
</div>


@section('javascript')
    <!-- ckeditor.js, load it only in the page you would like to use CKEditor (it's a heavy plugin to include it with the others!) -->
    {{ HTML::script('assets/admin/js/plugins/ckeditor/ckeditor.js') }}


    <script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
    {{ HTML::script('vendors/ubilabs-geocomplete/jquery.geocomplete.js') }}

    <!-- Load and execute javascript code used only in this page -->
    {{ HTML::script('assets/admin/js/pages/formsComponents.js') }}
    <script>$(function(){ FormsComponents.init(); });</script>


    <script>
        $(function()
        {

            @if( empty($store->formatted_address))
            var location = 'Guadalajara, Jalisco, Mexico';
                    @else
                        var location = new google.maps.LatLng({{ $store->lat }},{{ $store->lng }});
            @endif

            $("#geocomplete").geocomplete({
                        map: ".map_canvas_store",
                        details: "form",
                        mapOptions: {
                            scrollwheel: true
                        },
                        markerOptions: {
                            draggable: true
                        },
                        location: location,
                        detailsAttribute: 'data-geo'
                    });


            $("#geocomplete").bind("geocode:dragged", function(event, latLng){
                $("input[name=lat]").val(latLng.lat());
                $("input[name=lng]").val(latLng.lng());
            });


        });
    </script>

@stop