
<div class="modal-header">
    <button data-appointment-cancel-edit type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 class="modal-title"><strong>Editar cita</strong> <small class="label label-primary">{{ $appointment->store->name }}</small></h3>
</div>
<div class="modal-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {{ Form::open(['route' => ['api.appointments.update', $appointment->id], 'data-appointment-edit' => '', 'method' => 'POST', 'class' => 'clearfix']) }}


                {{-- Cliente -  TEXT --}}
                <div class="form-group col-md-12 {{ $errors->first('customer') ? 'has-error' : '' }}">

                    {{ Form::label('customer_name', 'Cliente', array('class' => 'col-md-4 control-label'))  }}
                    <div class="col-md-8">
                        {{ Form::text('customer_name', ($appointment->customer->first_name . ' ' . $appointment->customer->last_name), array('class' => 'form-control', 'placeholder' => '', 'id' => 'customer_name', 'readonly' => '')) }}

                        {{ Form::hidden('customer_id', null, ['id' => 'customer_id']) }}

                        @if( $errors->first('customer'))
                            <p class="help-block">{{ $errors->first('customer')  }}</p>
                        @endif
                    </div>
                </div>

                {{-- Apodo -  TEXT --}}
                <div class="form-group col-md-12 {{ $errors->first('customer_aka') ? 'has-error' : '' }}">

                    {{ Form::label('customer_aka', 'Apodo', array('class' => 'col-md-4 control-label'))  }}
                    <div class="col-md-8">
                        {{ Form::text('customer_aka', $appointment->customer->aka, array('class' => 'form-control', 'placeholder' => '', 'id' => 'customer_aka', 'readonly' => '')) }}
                        @if( $errors->first('customer_aka'))
                            <p class="help-block">{{ $errors->first('customer_aka')  }}</p>
                        @endif
                    </div>
                </div>


                {{-- Sucursal -  TEXT --}}
                <div class="form-group col-md-12 {{ $errors->first('store') ? 'has-error' : '' }}">

                    {{ Form::label('store', 'Sucursal', array('class' => 'col-md-4 control-label'))  }}
                    <div class="col-md-8">
                        {{ Form::text('store', $store->name, array('class' => 'form-control', 'placeholder' => '', 'id' => 'store', 'readonly' => '')) }}
                        {{ Form::hidden('store_id', $store->id) }}
                        @if( $errors->first('store'))
                            <p class="help-block">{{ $errors->first('store')  }}</p>
                        @endif
                    </div>
                </div>


                {{-- Fecha de cita: - DATE PICKER --}}
                <div class="form-group col-md-12  {{ $errors->first('appointment_date') ? 'has-error' : '' }}">
                    {{ Form::label('appointment_date', 'Fecha de cita:', array('class' => 'col-md-4 control-label'))  }}
                    <div class="col-md-5">
                        {{ Form::text('appointment_date', $appointment->start->toDateString(), array('class' => 'form-control input-datepicker', 'placeholder' => 'yyyy-mm-dd', 'id' => 'appointment_date', 'data-date-format' => 'yyyy-mm-dd', 'readonly' => true, 'data-appointment-date-edit' => '')) }}
                        @if( $errors->first('appointment_date'))
                            <p class="help-block">{{ $errors->first('appointment_date')  }}</p>
                        @endif
                    </div>
                </div>
                {{-- Form::hidden('appointment_date', $appointment->start->toDateString(), ['id' => 'appointment-date', 'data-appointment-date-edit' => '']) --}}


                {{--  Hora de Inicio - TIME --}}
                <div class="form-group col-md-12 {{ $errors->first('start') ? 'has-error' : '' }}">
                    <label class="col-md-4 control-label" for="start">Hora de Inicio</label>
                    <div class="col-md-8">
                        <div class="input-group bootstrap-timepicker">
                            {{ Form::text('start', $appointment_start, array('class' => 'form-control input-timepicker', 'id' => 'start', 'readonly' => true, 'data-appointment-start-edit' => '')) }}
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
                <div class="form-group col-md-12 {{ $errors->first('end') ? 'has-error' : '' }}">
                    <label class="col-md-4 control-label" for="end">Hora fin</label>
                    <div class="col-md-8">
                        <div class="input-group bootstrap-timepicker">
                            {{ Form::text('end', $appointment_end, array('class' => 'form-control input-timepicker', 'id' => 'end', 'readonly' => true, 'data-appointment-end-edit' => '')) }}
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
                <div class="form-group col-md-12 {{ $errors->first('services') ? 'has-error' : '' }}">

                    {{ Form::label('services', 'Servicios', array('class' => 'col-md-4 control-label'))  }}
                    <div class="col-md-8">

                        <select class="select-select2" placeholder="" data-placeholder="Servicios" style="width: 100%;" id="services" multiple data-appointment-services-edit>
                            @foreach($services as $service)
                                <option {{ in_array($service->id, $services_selected) ? 'selected' : '' }} data-time="{{ $service->estimated_time }}" value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>

                        @if( $errors->first('services'))
                            <span class="help-block">{{ $errors->first('services')  }}</span>
                        @endif
                    </div>
                </div>

                <?php
                    $status_options = [];

                    switch($appointment->status)
                    {
                        case 'canceled':
                            $status_options = ['canceled' => 'Cancelada'];
                            break;
                        case 'process':
                            $status_options = ['process' => 'En proceso'];
                            break;
                        case 'completed':
                            $status_options = ['completed' => 'Completada'];
                            break;
                        default:
                            $status_options = ['pending' => 'Pendiente de confirmar', 'confirmed' => 'Confirmada'];
                            break;
                    }
                ?>

                {{-- Estatus de la cita -  SELECT2 --}}
                <div class="form-group col-md-12 {{ $errors->first('status') ? 'has-error' : '' }}">

                    {{ Form::label('status_edit', 'Estatus de la cita', array('class' => 'col-md-4 control-label'))  }}
                    <div class="col-md-8">
                        {{ Form::select('status_edit', ($status_options), $appointment->status, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Estatus', 'style' => 'width: 100%;', 'id' => 'status_edit', ($appointment->status == 'process' ? 'readonly' : 'data-status') => ($appointment->status == 'process' ? true : false))) }}

                        @if( $errors->first('status_edit'))
                            <span class="help-block">{{ $errors->first('status_edit')  }}</span>
                        @endif

                    </div>
                </div>


                {{-- FORM ACTIONS --}}
                <div style="padding-top: 2em;" class="form-group form-actions col-md-12">
                    <div class="col-md-8 col-md-offset-4">

                        @if ( empty($appointment->sale->status))
                            <button type="submit" class="btn btn-effect-ripple btn-primary">Actualizar cita</button>
                        @endif

                    </div>

                </div>
                {{ Form::close() }}

            </div>

        </div>
    </div>


</div>
<div class="modal-footer">

    <div class="pull-left">
        @if ( empty($appointment->sale->status))
            {{ Form::open(['route' => ['api.appointments.destroy', $appointment->id], 'method' => 'DELETE', 'data-cancel-appointment']) }}
            {{ Form::button('Cancelar cita', array('class' => 'btn btn-effect-ripple btn-danger', 'type' => 'submit')) }}
            {{ Form::close() }}
        @endif


            @if ( ! empty($appointment->sale->status) and $appointment->sale->status == 'pending')
                {{--<a href="{{ route('sales.edit', [$company, $appointment->sale->id, 'store' => $store->id]) }}" class="btn btn-effect-ripple btn-info">Editar venta</a>--}}
            @endif
    </div>

    <div class="pull-right">

        @if ( empty($appointment->sale->status))
            {{ Form::open(array('route' => array('sales.store',  $company, 'store' => $store->id, 'appointment' => $appointment->id), 'method' => 'POST', 'class' => 'form-inline', 'style' => 'text-align: right;', 'data-sales-create' => 'appointment')) }}
            <button type="submit" class="btn btn-effect-ripple btn-info">Generar venta</button>
            {{ Form::close() }}
        @endif

        @if ( ! empty($appointment->sale->status) and $appointment->sale->status == 'pending' and $appointment->status == 'process')
            {{--{{ Form::open(array('route' => array('sales.update', $company, $appointment->sale->id, 'store' => $store->id), 'method' => 'PATCH', 'class' => 'form-inline','data-destroy-resource' => '', 'data-destroy-resource-message' => 'Estas a punto de registrar la cita como PAGADA. ¿Deseas continuar?', 'style' => 'text-align: right;')) }}--}}
            {{--<button type="submit" class="btn btn-effect-ripple btn-success btn-sm" data-toggle="popover" data-placement="top"><i class="fa fa-dollar"></i> Pagar</button>--}}
            {{--{{ Form::close() }}--}}
            <a href="{{ route('sales.edit', [$company, $appointment->sale->id, 'store' => $store->id]) }}" class="btn btn-effect-ripple btn-success"><i class="fa fa-dollar"></i> Pagar</a>
        @endif


    @if ( ! empty($appointment->sale->status) and $appointment->status == 'process')
        <span class="help-block">
            La cita ya se encuentra en proceso.
        </span>
    @elseif ( ! empty($appointment->sale->status) and $appointment->status == 'completed')
        <span class="help-block">
            La cita ya ha sido atendida.
        </span>
    @endif
    </div>
</div>

<!--script src="{{ asset('vendors/moment/moment.js') }}"></script-->
<script>

    $('.select-select2').select2();

    var start       = $('#start').val('{{ $appointment_start }}'),
            end     = $('#end').val('{{ $appointment_end }}');

    $('.input-datepicker, .input-daterange').datepicker({weekStart: 1, language: 'es'}).on('changeDate', function(e){ $(this).datepicker('hide'); });

    $('#start.input-timepicker').timepicker({
            minuteStep: 30,
            showSeconds: false,
            showMeridian: true,
            defaultTime: start
        });

    $('#end.input-timepicker').timepicker({
            minuteStep: 30,
            showSeconds: false,
            showMeridian: true,
            defaultTime: end
        });

    /**
     * Calcula el tiempo de la cita
     */
    $(document).on('change', '#services', function(e)
    {
        var $select = $(this),
                values = $select.val() || null
        minutes = 0;

        if (values)
        {
            for(var i = 0; i < values.length; i++)
            {
                var id =values[i],
                        time = $select.find('option[value="' + id + '"]').data('time');

                minutes += time;
            }

            var end       = $('#start').val();
            var endMoment = moment(end, 'HH:mm A');

            endMoment = endMoment.add(minutes, 'minutes');

            $('#end.input-timepicker').timepicker('setTime', endMoment.toDate());
        }
    });

    $('[data-sales-create="appointment"]').on('submit', function(e)
    {
        e.preventDefault();

        var isCardPayment = false;
        var tipAmount = null;
        /*var isCardPayment = confirm('¿El pago será realizado con tarjeta de crédito o débito?');
        var tipAmount     = 0;

        if (isCardPayment)
        {
            tipAmount = prompt("Ingresa el monto de la Propina:") || 0;
        }*/


        var $form             = $(this),
                $submitButton = $form.find('[type="submit"]'),
                textButton    = $submitButton.text(),
                data          = {
                    store_id: {{ $store->id }},
                    type: isCardPayment ? 'card' : 'cash',
                    tip: tipAmount
                };

        if ( confirm('Estas a punto de generar una venta con estatus PENDIENTE. ¿Deseas continuar?'))
        {

            $submitButton.html('<i class="fa fa-spinner fa-cog"></i> Generando venta..');
            $submitButton.prop('disabled', true);

            $.ajax({
                url: $form.prop('action'),
                dataType: 'json',
                type: 'POST',
                data: data,
                success: function(response){

                    var n = noty({
                        text: '<i class="fa fa-check"></i> La venta se ha registrado correctamente.',
                        animation: {
                            open: 'animated bounceInLeft', // Animate.css class names
                            close: 'animated bounceOutLeft', // Animate.css class names
                            easing: 'swing', // unavailable - no need
                            speed: 500 // unavailable - no need
                        }
                    });

                    $('#modal-master-edit').modal('hide');

                    $submitButton.prop('disabled', true);
                    $submitButton.html(textButton);

                    // Elimina los botones de generar venta y cancelar cita
                    $('[data-cancel-appointment],[data-sales-create="appointment"]').remove();

                    $('.modal-footer').find('.pull-right').append('<span class="help-block">La cita ya se encuentra en proceso. </span>');

                },
                error: function(xhr, textStatus, error){

                    var msg = 'Ocurrió un error al registrar la venta, intente nuevamente por favor.',
                            errors = xhr.responseJSON.error.message || {};

                    switch(xhr.status)
                    {
                        case 400:
                            msg = 'Por favor verifique la información.<br /><br />';

                            if (errors)
                            {
                                msg += '<ul>';
                                for (var key in errors)
                                {
                                    if (errors.hasOwnProperty(key))
                                    {
                                        msg += '<li>' + errors[key] + '</li>';
                                    }
                                }
                                msg += '</ul>';
                            }

                            break;
                        case 500:
                            msg = 'Ocurrió un error al registrar la venta, intente nuevamente por favor.';
                            break;
                    }

                    var n = noty({
                        text: '<i class="fa fa-warning"></i> ' + msg,
                        animation: {
                            open: 'animated bounceInLeft', // Animate.css class names
                            close: 'animated bounceOutLeft', // Animate.css class names
                            easing: 'swing', // unavailable - no need
                            speed: 500 // unavailable - no need
                        },
                        type: 'error'
                    });

                    $submitButton.prop('disabled', false);
                    $submitButton.html(textButton);
                }
            });
        }

    });
</script>