{{-- Fecha -  TEXT --}}
<div class="form-group">

    {{ Form::label('date', 'Fecha', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        <p class="form-control-static">{{ $checkin->checkin->format('Y-m-d') }}</p>
    </div>
</div>

{{-- Hora -  TEXT --}}
<div class="form-group">
    
    {{ Form::label('time', 'Hora', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        <p class="form-control-static">{{ $checkin->checkin->format('G:i:s A') }}</p>
    </div>
</div>


{{-- Estatus -  SELECT2 --}}
<div class="form-group {{ $errors->first('status') ? 'has-error' : '' }}">

    {{ Form::label('status', 'Estatus', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-5">
        {{ Form::select('status', $statuses, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Zona', 'style' => 'width: 100%;', 'id' => 'status')) }}

        @if( $errors->first('status'))
            <span class="help-block">{{ $errors->first('status')  }}</span>
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