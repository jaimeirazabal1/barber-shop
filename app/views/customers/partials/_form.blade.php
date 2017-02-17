{{-- Nombre(s) -  TEXT --}}
<div class="form-group {{ $errors->first('first_name') ? 'has-error' : '' }}">

    {{ Form::label('first_name', 'Nombre(s)', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('first_name', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'first_name')) }}
        @if( $errors->first('first_name'))
            <p class="help-block">{{ $errors->first('first_name')  }}</p>
        @endif
    </div>
</div>


{{-- Apellidos -  TEXT --}}
<div class="form-group {{ $errors->first('last_name') ? 'has-error' : '' }}">

    {{ Form::label('last_name', 'Apellidos', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('last_name', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'last_name')) }}
        @if( $errors->first('last_name'))
            <p class="help-block">{{ $errors->first('last_name')  }}</p>
        @endif
    </div>
</div>


{{-- Apodo -  TEXT --}}
<div class="form-group {{ $errors->first('aka') ? 'has-error' : '' }}">

    {{ Form::label('aka', 'Apodo', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('aka', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'aka')) }}
        @if( $errors->first('aka'))
            <p class="help-block">{{ $errors->first('aka')  }}</p>
        @endif
    </div>
</div>


{{-- Correo electrónico -  TEXT --}}
<div class="form-group {{ $errors->first('email') ? 'has-error' : '' }}">

    {{ Form::label('email', 'Correo electrónico', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'email', 'data-email-validation' => 'inline', (empty($customer->email) ? '' : 'readonly') => (empty($customer->email) ? '' : 'true'))) }}
        @if( $errors->first('email'))
            <p class="help-block">{{ $errors->first('email')  }}</p>
        @endif
    </div>
</div>

{{-- Enviar notificaciones por correo electrónico -  SWITCH --}}
<div {{ (empty($customer->email) ? ' style="display: none;" ' : '' ) }} data-email-extra-data class="form-group {{ $errors->first('send_email_notifications') ? 'has-error' : '' }}">

    <div class="col-md-4 col-md-offset-4">
        <label class="switch switch-info">{{ Form::checkbox('send_email_notifications', 'true') }}<span></span></label>

            
        <span class="help-block">Enviar notificaciones por correo electrónico.</span>
    </div>
    @if ( empty($customer->email) or empty($customer->user))
    <div class="col-md-4">
        <label class="switch switch-info">{{ Form::checkbox('create_user_account', 'true') }}<span></span></label>


        <span class="help-block">Crear cuenta de usuario para el cliente.</span>
    </div>
    @endif
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


{{-- Celular -  TEXT --}}
<div class="form-group {{ $errors->first('cellphone') ? 'has-error' : '' }}">

    {{ Form::label('cellphone', 'Celular', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('cellphone', null, array('class' => 'form-control', 'id' => 'cellphone', 'data-phone-validation' => 'inline', 'data-mobile-number' => '')) }}

        {{ Form::hidden('cellphone_formatted', null,['data-mobile-number-formatted']) }}

        <p class="help-block" data-cellphone-preview>

        </p>

        @if( $errors->first('cellphone'))
            <p class="help-block">{{ $errors->first('cellphone')  }}</p>
        @endif

    </div>
</div>

{{-- Enviar notificaciones por correo electrónico -  SWITCH --}}
<div {{ (empty($customer->cellphone) ? ' style="display: none;" ' : '' ) }}  data-phone-extra-data class="form-group {{ $errors->first('send_cellphone_notifications') ? 'has-error' : '' }}">

    <div class="col-md-8 col-md-offset-4">
        <label class="switch switch-info">{{ Form::checkbox('send_cellphone_notifications', 'true') }}<span></span></label>


        <span class="help-block">Enviar notificaciones por SMS.</span>
    </div>
</div>


{{-- Día -  SELECT2 --}}
<div class="form-group {{ $errors->first('birthdate_day') ? 'has-error' : '' }}">

    {{ Form::label('birthdate_day', 'Fecha de nacimiento', array('class' => 'col-md-4 control-label'))  }}

    <div class="col-md-2">
        {{ Form::select('birthdate_day', $days, empty($customer->birthdate) ? null : $customer->birthdate->day, array('class' => 'form-control', 'placeholder' => '', 'data-placeholder' => '', 'style' => '', 'id' => 'birthdate_day')) }}
    </div>
    <div class="col-md-2">
        {{ Form::select('birthdate_month', $months, empty($customer->birthdate) ? null : $customer->birthdate->month, array('class' => 'form-control', 'placeholder' => '', 'data-placeholder' => '', 'style' => '', 'id' => 'birthdate_month')) }}
    </div>
    <div class="col-md-2">
        {{ Form::select('birthdate_year', $years, empty($customer->birthdate) ? null : $customer->birthdate->year, array('class' => 'form-control', 'placeholder' => '', 'data-placeholder' => '', 'style' => '', 'id' => 'birthdate_year')) }}
    </div>


    @if( $errors->first('birthdate_day'))
        <div class="col-md-8 col-md-offset-4">
            <span class="help-block">{{ $errors->first('birthdate_day')  }}</span>
        </div>
    @endif

</div>




{{-- Barbero -  SELECT2 --}}
<div class="form-group {{ $errors->first('barber_id') ? 'has-error' : '' }}">

    {{ Form::label('barber_id', 'Barbero', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-5">
        {{ Form::select('barber_id', $barbers, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Barbero de preferencia', 'style' => 'width: 100%;', 'id' => 'barber_id')) }}

        @if( $errors->first('barber_id'))
            <span class="help-block">{{ $errors->first('barber_id')  }}</span>
        @endif

    </div>
</div>



{{-- Notas -  TEXTAREA --}}
<div class="form-group {{ $errors->first('notes')? 'has-error' : '' }}">

    {{ Form::label('notes', 'Notas', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::textarea('notes', null, array('class' => 'form-control', 'rows' => 7,  'placeholder' => '', 'id' => 'notes')) }}
        @if( $errors->first('notes'))
            <span class="help-block">{{ $errors->first('notes')  }}</span>
        @endif
    </div>
</div>



<fieldset>

    <legend>Servicios preferidos</legend>


    {{-- Servicios -  SELECT2 --}}
    <div class="form-group {{ $errors->first('services_options') ? 'has-error' : '' }}">

        {{ Form::label('services_options', 'Servicios', array('class' => 'col-md-4 control-label'))  }}
        <div class="col-md-6">
            {{ Form::select('services_options', $services, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Servicios', 'style' => 'width: 100%;', 'id' => 'services_options', 'data-service-options' => '')) }}
        </div>
        <div class="col-md-2">
            <a data-add-service href="#" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar servicio"><i class="fa fa-plus-circle"></i></a>
        </div>
    </div>



    <br />
    <br />
    <br />

    @if ( ! empty($customer->services))
        @foreach($customer->services as $service)

            <div class="form-group" data-service-id="{{ $service->id }}">
                <label class="col-md-8 col-md-offset-4">
                    <a data-service-destroy="{{ $service->id }}" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar"><i class="fa fa-times"></i></a>
                    {{ $service->name }}
                </label>
                <input type="hidden" value="{{ $service->pivot->estimated_time }}" name="services[{{ $service->id }}]" />
            </div>

        @endforeach
    @endif


    <span data-service-before-insert></span>

    <br />
    <br />
    <br />
</fieldset>



{{-- FORM ACTIONS --}}
<div class="form-group form-actions">
    <div class="col-md-8 col-md-offset-4">
        {{ Form::submit('Guardar', array('class' => 'btn btn-effect-ripple btn-primary')) }}
        {{ Form::reset('Limpiar formulario', array('class' => 'btn btn-effect-ripple btn-danger')) }}
    </div>
</div>