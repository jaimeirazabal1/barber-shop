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


{{-- Dirección -  TEXTAREA --}}
<div class="form-group {{ $errors->first('address')? 'has-error' : '' }}">

    {{ Form::label('address', 'Dirección', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::textarea('address', null, array('class' => 'form-control', 'rows' => 7,  'placeholder' => '', 'id' => 'address')) }}
        @if( $errors->first('address'))
            <span class="help-block">{{ $errors->first('address')  }}</span>
        @endif
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

{{-- Celular -  TEXT --}}
<div class="form-group {{ $errors->first('cellphone') ? 'has-error' : '' }}">

    {{ Form::label('cellphone', 'Celular', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('cellphone', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'cellphone')) }}
        @if( $errors->first('cellphone'))
            <p class="help-block">{{ $errors->first('cellphone')  }}</p>
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

{{-- Código de Checador -  TEXT --}}
<div class="form-group {{ $errors->first('code') ? 'has-error' : '' }}">

    {{ Form::label('code', 'Código de Checador', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('code', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'code')) }}
        @if( $errors->first('code'))
            <p class="help-block">{{ $errors->first('code')  }}</p>
        @endif
    </div>
</div>


<div class="form-group {{ $errors->first('color') ? 'has-error' : '' }}">
    {{ Form::label('color', 'Color', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-5">
        <div class="input-group input-colorpicker">
            {{ Form::text('color', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'color', 'readonly' => true)) }}
            <span class="input-group-addon"><i></i></span>
        </div>
        @if( $errors->first('color'))
            <p class="help-block">{{ $errors->first('color')  }}</p>
        @endif
    </div>
</div>


{{-- Tipo de Salario -  SELECT2 --}}
<!--div class="form-group {{ $errors->first('salary_type') ? 'has-error' : '' }}">

    {{ Form::label('salary_type', 'Tipo de Salario', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-5">
        {{ Form::select('salary_type', $salaries, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Tipo de Salario', 'style' => 'width: 100%;', 'id' => 'salary_type')) }}

        @if( $errors->first('salary_type'))
            <span class="help-block">{{ $errors->first('salary_type')  }}</span>
        @endif

    </div>
</div-->

{{-- Salario -  TEXT --}}
<div class="form-group {{ $errors->first('salary') ? 'has-error' : '' }}">

    {{ Form::label('salary', 'Salario semanal', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('salary', empty($barber->salary) ? null : convertIntegerToMoney($barber->salary), array('class' => 'form-control', 'placeholder' => '0.00', 'id' => 'salary')) }}
        @if( $errors->first('salary'))
            <p class="help-block">{{ $errors->first('salary')  }}</p>
        @endif
    </div>
</div>


{{-- Sucursal -  SELECT2 --}}
<div class="form-group {{ $errors->first('store_id') ? 'has-error' : '' }}">

    {{ Form::label('store_id', 'Sucursal', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-7">
        {{ Form::select('store_id', $stores, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Sucursal', 'style' => 'width: 100%;', 'id' => 'store_id')) }}

        @if( $errors->first('store_id'))
            <span class="help-block">{{ $errors->first('store_id')  }}</span>
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



<fieldset>

    <legend>Horario</legend>


    {{--  Hora de Inicio - TIME --}}
    <div class="form-group {{ $errors->first('check_in') ? 'has-error' : '' }}">
        <label class="col-md-4 control-label" for="check_in">Hora de entrada</label>
        <div class="col-md-5">
            <div class="input-group bootstrap-timepicker">
                {{ Form::text('check_in', empty($check_in) ? null : $check_in, array('class' => 'form-control input-timepicker', 'id' => 'check_in', 'readonly' => true)) }}
                <span class="input-group-btn">
                    <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                </span>
            </div>
            @if( $errors->first('check_in'))
                <p class="help-block">{{ $errors->first('check_in') }}</p>
            @endif
        </div>
    </div>


    {{--  Hora de Inicio - TIME --}}
    <div class="form-group {{ $errors->first('mealtime_in') ? 'has-error' : '' }}">
        <label class="col-md-4 control-label" for="mealtime_in">Comida - Hora de Inicio</label>
        <div class="col-md-5">
            <div class="input-group bootstrap-timepicker">
                {{ Form::text('mealtime_in', empty($mealtime_in) ? null : $mealtime_in, array('class' => 'form-control input-timepicker', 'id' => 'mealtime_in', 'readonly' => true)) }}
                <span class="input-group-btn">
                    <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                </span>
            </div>
            @if( $errors->first('mealtime_in'))
                <p class="help-block">{{ $errors->first('mealtime_in') }}</p>
            @endif
        </div>
    </div>


    {{--  Hora de fin - TIME --}}
    <div class="form-group {{ $errors->first('mealtime_out') ? 'has-error' : '' }}">
        <label class="col-md-4 control-label" for="mealtime_out">Comida - Hora de fin</label>
        <div class="col-md-5">
            <div class="input-group bootstrap-timepicker">
                {{ Form::text('mealtime_out', empty($mealtime_out) ? null : $mealtime_out, array('class' => 'form-control input-timepicker', 'id' => 'mealtime_out', 'readonly' => true)) }}
                <span class="input-group-btn">
                    <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                </span>
            </div>
            @if( $errors->first('mealtime_out'))
                <p class="help-block">{{ $errors->first('mealtime_out') }}</p>
            @endif
        </div>
    </div>

    {{--  Hora de fin - TIME --}}
    <div class="form-group {{ $errors->first('check_out') ? 'has-error' : '' }}">
        <label class="col-md-4 control-label" for="check_out">Hora de salida</label>
        <div class="col-md-5">
            <div class="input-group bootstrap-timepicker">
                {{ Form::text('check_out', empty($check_out) ? null : $check_out, array('class' => 'form-control input-timepicker', 'id' => 'check_out', 'readonly' => true)) }}
                <span class="input-group-btn">
                    <a href="javascript:void(0)" class="btn btn-effect-ripple btn-primary"><i class="fa fa-clock-o"></i></a>
                </span>
            </div>
            @if( $errors->first('check_out'))
                <p class="help-block">{{ $errors->first('check_out') }}</p>
            @endif
        </div>
    </div>

</fieldset>


<br />
<br />
<br />


{{-- FORM ACTIONS --}}
<div class="form-group form-actions">
    <div class="col-md-8 col-md-offset-4">
        {{ Form::submit('Guardar', array('class' => 'btn btn-effect-ripple btn-primary')) }}
        {{ Form::reset('Limpiar formulario', array('class' => 'btn btn-effect-ripple btn-danger')) }}
    </div>
</div>