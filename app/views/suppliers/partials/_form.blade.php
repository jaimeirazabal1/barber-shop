{{-- Nombre -  TEXT --}}
<div class="form-group {{ $errors->first('name') ? 'has-error' : '' }}">

    {{ Form::label('name', 'Nombre', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'name')) }}
        @if( $errors->first('name'))
            <p class="help-block">{{ $errors->first('name')  }}</p>
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


{{-- Teléfono -  TEXTAREA --}}
<div class="form-group {{ $errors->first('phone')? 'has-error' : '' }}">

    {{ Form::label('phone', 'Teléfono', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::textarea('phone', null, array('class' => 'form-control', 'rows' => 7,  'placeholder' => '', 'id' => 'phone')) }}
        @if( $errors->first('phone'))
            <span class="help-block">{{ $errors->first('phone')  }}</span>
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


{{-- FORM ACTIONS --}}
<div class="form-group form-actions">
    <div class="col-md-8 col-md-offset-4">
        {{ Form::submit('Guardar', array('class' => 'btn btn-effect-ripple btn-primary')) }}
        {{ Form::reset('Limpiar formulario', array('class' => 'btn btn-effect-ripple btn-danger')) }}
    </div>
</div>