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

{{-- FORM ACTIONS --}}
<div class="form-group form-actions">
    <div class="col-md-9 col-md-offset-3">
        {{ Form::submit('Guardar', array('class' => 'btn btn-effect-ripple btn-primary')) }}
        {{ Form::reset('Limpiar formulario', array('class' => 'btn btn-effect-ripple btn-danger')) }}
    </div>
</div>