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

{{-- Código de Servicio -  TEXT --}}
<div class="form-group {{ $errors->first('code') ? 'has-error' : '' }}">

    {{ Form::label('code', 'Código de Servicio', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('code', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'code')) }}
        @if( $errors->first('code'))
            <p class="help-block">{{ $errors->first('code')  }}</p>
        @endif
    </div>
</div>

{{-- Costo -  TEXT --}}
<div class="form-group {{ $errors->first('price') ? 'has-error' : '' }}">

    {{ Form::label('price', 'Costo', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('price', empty($service->code) ? null : convertIntegerToMoney($service->price), array('class' => 'form-control', 'placeholder' => '', 'id' => 'price')) }}
        @if( $errors->first('price'))
            <p class="help-block">{{ $errors->first('price')  }}</p>
        @endif
    </div>
</div>

{{-- Tiempo estimado -  SELECT2 --}}
<div class="form-group {{ $errors->first('estimated_time') ? 'has-error' : '' }}">

    {{ Form::label('estimated_time', 'Tiempo estimado', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-5">
        {{ Form::select('estimated_time', array('30' => '30 min.', '60' => '60 min.', '90' => '90 min.', '120' => '120 min.'), null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Zona', 'style' => 'width: 100%;', 'id' => 'estimated_time')) }}
        
        @if( $errors->first('estimated_time'))
            <span class="help-block">{{ $errors->first('estimated_time')  }}</span>
        @endif
        
    </div>
</div>


{{-- Categoría -  SELECT2 --}}
<div class="form-group {{ $errors->first('category_id') ? 'has-error' : '' }}">

    {{ Form::label('category_id', 'Categoría', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-7">
        {{ Form::select('category_id', $categories, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Categoría', 'style' => 'width: 100%;', 'id' => 'category_id')) }}

        @if( $errors->first('category_id'))
            <span class="help-block">{{ $errors->first('category_id')  }}</span>
        @endif

    </div>
</div>


{{-- Etiquetas -  SELECT2 MULTIPLE --}}
<div class="form-group {{ $errors->first('tags') ? 'has-error' : '' }}">

    {{ Form::label('tags', 'Etiquetas', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::select('tags[]', $tags, empty($tagsSelected) ? null : $tagsSelected, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Etiquetas...', 'style' => 'width: 100%;', 'id' => 'tags', 'multiple' => '')) }}

        @if( $errors->first('tags'))
            <span class="help-block">{{ $errors->first('tags')  }}</span>
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



{{-- FORM ACTIONS --}}
<div class="form-group form-actions">
    <div class="col-md-8 col-md-offset-4">
        {{ Form::submit('Guardar', array('class' => 'btn btn-effect-ripple btn-primary')) }}
        {{ Form::reset('Limpiar formulario', array('class' => 'btn btn-effect-ripple btn-danger')) }}
    </div>
</div>