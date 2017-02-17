    

    {{-- Cliente -  TEXT --}}
    <div class="form-group {{ $errors->first('customer') ? 'has-error' : '' }}">

        {{ Form::label('customer', 'Cliente', array('class' => 'col-md-4 control-label'))  }}
        <div class="col-md-8">
            {{ Form::text('customer', empty($appointment) ? 'Venta sucursal' : ($appointment->customer->first_name . ' ' . $appointment->customer->last_name), array('class' => 'form-control', 'placeholder' => '', 'id' => 'customer', 'readonly' => '')) }}
            @if( $errors->first('customer'))
                <p class="help-block">{{ $errors->first('customer')  }}</p>
            @endif
        </div>
    </div>

    {{ Form::hidden('customer_id', empty($appointment) ? null : $appointment->customer->id) }}

    @if ( ! empty($appointment))
    {{-- Apodo -  TEXT --}}
    <div class="form-group {{ $errors->first('customer_aka') ? 'has-error' : '' }}">

        {{ Form::label('customer_aka', 'Apodo', array('class' => 'col-md-4 control-label'))  }}
        <div class="col-md-8">
            {{ Form::text('customer_aka', empty($appointment) ? null : $appointment->customer->aka, array('class' => 'form-control', 'placeholder' => '', 'id' => 'customer_aka', 'readonly' => '')) }}
            @if( $errors->first('customer_aka'))
                <p class="help-block">{{ $errors->first('customer_aka')  }}</p>
            @endif
        </div>
    </div>
    @endif

@if ($appointment)

    {{-- Fecha -  TEXT --}}
    <div class="form-group {{ $errors->first('date') ? 'has-error' : '' }}">

        {{ Form::label('date', 'Fecha', array('class' => 'col-md-4 control-label'))  }}
        <div class="col-md-8">
            {{ Form::text('date', $appointment->start->toDateString(), array('class' => 'form-control', 'placeholder' => '', 'id' => 'date', 'readonly' => '')) }}
            @if( $errors->first('date'))
                <p class="help-block">{{ $errors->first('date')  }}</p>
            @endif
        </div>
    </div>


    {{-- Hora de Inicio -  TEXT --}}
    <div class="form-group {{ $errors->first('start') ? 'has-error' : '' }}">

        {{ Form::label('start', 'Hora de Inicio', array('class' => 'col-md-4 control-label'))  }}
        <div class="col-md-5">
            {{ Form::text('start', $appointment->start->format('h:i A'), array('class' => 'form-control', 'placeholder' => '', 'id' => 'start', 'readonly' => '')) }}
            @if( $errors->first('start'))
                <p class="help-block">{{ $errors->first('start')  }}</p>
            @endif
        </div>
    </div>


    {{-- Hora de fin -  TEXT --}}
    <div class="form-group {{ $errors->first('end') ? 'has-error' : '' }}">

        {{ Form::label('end', 'Hora de fin', array('class' => 'col-md-4 control-label'))  }}
        <div class="col-md-5">
            {{ Form::text('end', $appointment->end->format('h:i A'), array('class' => 'form-control', 'placeholder' => '', 'id' => 'end', 'readonly' => '')) }}
            @if( $errors->first('end'))
                <p class="help-block">{{ $errors->first('end')  }}</p>
            @endif
        </div>
    </div>


    {{ Form::hidden('products[]') }}


    @if ( ! empty($appointment))
        {{ Form::hidden('appointment_id', $appointment->id) }}
    @endif



@endif

    {{ Form::hidden('store_id', $store->id) }}




{{-- Comentarios generales -  TEXTAREA --}}
<div class="form-group {{ $errors->first('comments')? 'has-error' : '' }}">

    {{ Form::label('comments', 'Comentarios generales', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::textarea('comments', null, array('class' => 'form-control', 'rows' => 7,  'placeholder' => '', 'id' => 'comments')) }}
        @if( $errors->first('comments'))
            <span class="help-block">{{ $errors->first('comments')  }}</span>
        @endif
    </div>
</div>

    
{{-- Tipo de pago -  SELECT2 --}}
<div class="form-group {{ $errors->first('type') ? 'has-error' : '' }}">

    {{ Form::label('type', 'Tipo de pago', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-5">
        {{ Form::select('type', ['cash' => 'Efectivo', 'card' => 'Tarjeta crédito/débito'], empty($sale) ? null : $sale->type, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Zona', 'style' => 'width: 100%;', 'id' => 'type')) }}

        @if( $errors->first('type'))
            <span class="help-block">{{ $errors->first('type')  }}</span>
        @endif

    </div>
</div>

{{-- Propina -  TEXT --}}
<div data-tip-container style="display: {{ (empty($sale) ? 'none' : ($sale->type == 'cash' ? 'none' : 'block' ) ) }};" class="form-group {{ $errors->first('tip') ? 'has-error' : '' }}">

    {{ Form::label('tip', 'Propina', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-5">
        {{ Form::text('tip', empty($sale) ? null : convertIntegerToMoney($sale->tip), array('class' => 'form-control', 'placeholder' => '', 'id' => 'tip')) }}
        @if( $errors->first('tip'))
            <p class="help-block">{{ $errors->first('tip')  }}</p>
        @endif
    </div>
</div>


{{-- FORM ACTIONS --}}
<div class="form-group form-actions">
    <div class="col-md-8 col-md-offset-4">
        @if ( ! empty($sale->id))
            <button type="submit" class="btn btn-effect-ripple btn-success"><i class="fa fa-dollar"></i> Pagar</button>
        @else
            {{ Form::submit('Generar venta', array('class' => 'btn btn-effect-ripple btn-primary')) }}
            {{ Form::reset('Limpiar formulario', array('class' => 'btn btn-effect-ripple btn-danger')) }}
        @endif
    </div>
</div>



@section('javascript')
    <script>
        $(function(){

            $('select[name="type"]').on('change', function(){

                var $select = $(this),
                        type = $select.val(),
                        $tip = $('[data-tip-container]');

                if (type == 'cash')
                {
                    $tip.fadeOut();
                }
                else
                {
                    $tip.fadeIn();
                }

            });

        });
    </script>
@stop