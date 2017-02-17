{{-- Cliente -  TEXT --}}
<div class="form-group {{ $errors->first('customer') ? 'has-error' : '' }}">

    {{ Form::label('customer', 'Cliente', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('customer', empty($appointment->customer) ? null : $appointment->customer->first_name . ' ' . $appointment->customer->last_name, array('class' => 'form-control', 'placeholder' => '', 'id' => 'customer', 'readonly' => '')) }}

        {{ Form::hidden('customer_id', empty($appointment->customer->uuid) ? '' : $appointment->customer->uuid, array('id' => 'customer_id')) }}

        @if( $errors->first('customer'))
            <p class="help-block">{{ $errors->first('customer')  }}</p>
        @endif
    </div>
</div>


{{-- Apodo -  TEXT --}}
<div class="form-group {{ $errors->first('aka') ? 'has-error' : '' }}">

    {{ Form::label('aka', 'Apodo', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('aka', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'aka', 'readonly' => true)) }}
        @if( $errors->first('aka'))
            <p class="help-block">{{ $errors->first('aka')  }}</p>
        @endif
    </div>
</div>



{{-- Sucursal -  SELECT2 --}}
<div class="form-group {{ $errors->first('store_id') ? 'has-error' : '' }}">

    {{ Form::label('store_id', 'Sucursal', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-6">
        {{ Form::select('store_id', $stores, empty($appointment->store) ? null : $appointment->store->slug, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Zona', 'style' => 'width: 100%;', 'id' => 'store_id', 'data-store-barbers' => 'options')) }}

        @if( $errors->first('store_id'))
            <span class="help-block">{{ $errors->first('store_id')  }}</span>
        @endif

    </div>
</div>



{{-- Barbero -  SELECT2 --}}
<div class="form-group {{ $errors->first('barber_id') ? 'has-error' : '' }}">

    {{ Form::label('barber_id', 'Barbero', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-6">
        {{ Form::select('barber_id', empty($barbers) ? array('' => 'Barbero') : $barbers, empty($appointment->barber) ? null : $appointment->barber->uuid, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Barbero', 'style' => 'width: 100%;', 'id' => 'barber_id', 'data-get-single-resource-agenda' => '')) }}

        @if( $errors->first('barber_id'))
            <span class="help-block">{{ $errors->first('barber_id')  }}</span>
        @endif

    </div>
</div>


{{-- Fecha - DATE PICKER --}}
<div class="form-group  {{ $errors->first('date') ? 'has-error' : '' }}">
    {{ Form::label('date', 'Fecha', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-5">
        {{ Form::text('date', empty($appointment_date) ? date('Y-m-d') : $appointment_date, array('class' => 'form-control input-datepicker', 'placeholder' => 'yyyy-mm-dd', 'id' => 'date', 'data-date-format' => 'yyyy-mm-dd', 'readonly' => true, 'data-get-single-resource-agenda' => '')) }}
        @if( $errors->first('date'))
            <p class="help-block">{{ $errors->first('date')  }}</p>
        @endif
    </div>
</div>


{{--  Hora de Inicio - TIME --}}
<div class="form-group {{ $errors->first('start') ? 'has-error' : '' }}">
    <label class="col-md-4 control-label" for="start">Hora de Inicio</label>
    <div class="col-md-5">
        <div class="input-group bootstrap-timepicker">
            {{ Form::text('start', empty($appointment_start) ? null : $appointment_start, array('class' => 'form-control input-timepicker', 'id' => 'start', 'readonly' => true)) }}
            <span class="input-group-btn">
                <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
            </span>
        </div>
        @if( $errors->first('start'))
            <p class="help-block">{{ $errors->first('start') }}</p>
        @endif
    </div>
</div>

{{--  Hora fin - TIME --}}
<div class="form-group {{ $errors->first('end') ? 'has-error' : '' }}">
    <label class="col-md-4 control-label" for="end">Hora fin</label>
    <div class="col-md-5">
        <div class="input-group bootstrap-timepicker">
            {{ Form::text('end', empty($appointment_end) ? null : $appointment_end, array('class' => 'form-control input-timepicker', 'id' => 'end', 'readonly' => true)) }}
            <span class="input-group-btn">
                <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
            </span>
        </div>
        @if( $errors->first('end'))
            <p class="help-block">{{ $errors->first('end') }}</p>
        @endif
    </div>
</div>


{{-- Servicios -  SELECT2 MULTIPLE --}}
<div class="form-group {{ $errors->first('services') ? 'has-error' : '' }}">

    {{ Form::label('services', 'Servicios', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::select('services[]', $services, empty($appointmentServicesSelected) ? null : $appointmentServicesSelected, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Servicios', 'style' => 'width: 100%;', 'id' => 'services', 'multiple' => '')) }}

        @if( $errors->first('services'))
            <span class="help-block">{{ $errors->first('services')  }}</span>
        @endif
    </div>
</div>



{{-- Estatus de la cita -  SELECT2 --}}
<div class="form-group {{ $errors->first('status') ? 'has-error' : '' }}">

    {{ Form::label('status', 'Estatus de la cita', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-6">
        {{ Form::select('status', $statuses, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Zona', 'style' => 'width: 100%;', 'id' => 'status')) }}

        @if( $errors->first('status'))
            <span class="help-block">{{ $errors->first('status')  }}</span>
        @endif

    </div>
    <br >
    <br >
    <br >
</div>


{{-- FORM ACTIONS --}}
<div class="form-group form-actions">
    <div class="col-md-8 col-md-offset-4">
        {{ Form::submit('Agendar cita', array('class' => 'btn btn-effect-ripple btn-info')) }}
    </div>
</div>