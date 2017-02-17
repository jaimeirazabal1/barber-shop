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


{{-- Código de producto -  TEXT --}}
<div class="form-group {{ $errors->first('sku') ? 'has-error' : '' }}">

    {{ Form::label('sku', 'Código de producto', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('sku', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'sku')) }}
        @if( $errors->first('sku'))
            <p class="help-block">{{ $errors->first('sku')  }}</p>
        @endif
    </div>
</div>


{{-- Precio -  TEXT --}}
<div class="form-group {{ $errors->first('price') ? 'has-error' : '' }}">

    {{ Form::label('price', 'Precio', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('price', empty($product->price) ? null : convertIntegerToMoney($product->price), array('class' => 'form-control', 'placeholder' => '', 'id' => 'price')) }}
        @if( $errors->first('price'))
            <p class="help-block">{{ $errors->first('price')  }}</p>
        @endif
    </div>
</div>

{{-- Imagen - FILE --}}
<div class="form-group {{ $errors->first('image') ? 'has-error' : '' }}">
    {{ Form::label('image', 'Imagen', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">

        @if( ! empty($product->image))
            {{ HTML::image($product->image, $product->image, array('class' => 'img-responsive')) }}
        @endif

        {{ Form::file('image') }}
        @if( $errors->first('image'))
            <span class="help-block">{{ $errors->first('image')  }}</span>
        @endif
    </div>
</div>


{{-- Categoría -  SELECT2 --}}
<div class="form-group {{ $errors->first('category_id') ? 'has-error' : '' }}">

    {{ Form::label('category_id', 'Categoría', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::select('category_id', $categories, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Categoría', 'style' => 'width: 100%;', 'id' => 'category_id')) }}

        @if( $errors->first('category_id'))
            <span class="help-block">{{ $errors->first('category_id')  }}</span>
        @endif

    </div>
</div>


{{-- Proveedor -  SELECT2 --}}
<div class="form-group {{ $errors->first('supplier_id') ? 'has-error' : '' }}">

    {{ Form::label('supplier_id', 'Proveedor', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::select('supplier_id', $suppliers, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Proveedor', 'style' => 'width: 100%;', 'id' => 'supplier_id')) }}

        @if( $errors->first('supplier_id'))
            <span class="help-block">{{ $errors->first('supplier_id')  }}</span>
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


<fieldset>

    <legend>Existencias por sucursal</legend>

    @if ( ! empty($stores))
        @foreach($stores as $store)

            <div class="form-group" data-store-id="{{ $store->id }}">
                <label for="store-{{ $store->id }}" class="col-md-4 text-right text-muted">
                    {{ $store->name }}
                </label>
                <div class="col-md-2">
                    <input data-store-stock id="store-{{ $store->id }}" name="stores[{{ $store->id }}]" value="{{ array_key_exists($store->id, $stock) ? $stock[$store->id] : 0 }}" type="number" class="form-control" />
                </div>
            </div>

        @endforeach
    @endif


</fieldset>



{{-- FORM ACTIONS --}}
<div class="form-group form-actions">
    <div class="col-md-8 col-md-offset-4">
        {{ Form::submit('Guardar', array('class' => 'btn btn-effect-ripple btn-primary')) }}
        {{ Form::reset('Limpiar formulario', array('class' => 'btn btn-effect-ripple btn-danger')) }}
    </div>
</div>