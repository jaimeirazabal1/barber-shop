
<div class="modal-header">
    <button data-appointment-cancel-new type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 class="modal-title"><strong>Agendar cita</strong></h3>
</div>
<div class="modal-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                {{ Form::open(['route' => 'api.appointments.store', 'data-appointment-create' => '', 'method' => 'POST', 'class' => 'clearfix']) }}

                    {{-- Cliente -  TEXT --}}
                    <div class="form-group col-md-12 {{ $errors->first('customer') ? 'has-error' : '' }}">

                        {{ Form::label('customer_name', 'Cliente', array('class' => 'col-md-4 control-label'))  }}
                        <div class="col-md-8">
                            {{ Form::text('customer_name', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'customer_name', 'readonly' => '')) }}

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
                            {{ Form::text('customer_aka', null, array('class' => 'form-control', 'placeholder' => '', 'id' => 'customer_aka', 'readonly' => '')) }}
                            @if( $errors->first('customer_aka'))
                                <p class="help-block">{{ $errors->first('customer_aka')  }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Enviar e-mail de confirmación: -  SWITCH --}}
                    <div data-send-notification style="display: none;" class="form-group">

                        {{ Form::label('customer_notification_email', 'Notificaciones:', array('class' => 'col-md-4 control-label'))  }}
                        <div style="display: none;"  data-send-email-notification class="col-md-8">
                            <label class="switch switch-success">{{ Form::checkbox('customer_notification_email', 'true', null, ['id' => 'customer_notification_email']) }}<span></span></label>
                            <p class="help-block">Enviar notificación vía correo electrónico.</p>
                        </div>

                        <div style="display: none;"  data-send-sms-notification class="col-md-8 col-md-offset-4">
                            <label class="switch switch-success">{{ Form::checkbox('customer_notification_cellphone', 'true', null, ['id' => 'customer_notification_cellphone']) }}<span></span></label>
                            <p class="help-block">Enviar notificación vía SMS.</p>
                        </div>

                        <script>
                            {{-- Codeman Company --}}
                            var notification = {
                                email: document.getElementById( 'customer_notification_email' ),
                                sms: document.getElementById( 'customer_notification_cellphone' )
                            };
                            notification.email.checked = true;
                            notification.sms.checked = true
                        </script>
                    </div>


                    {{-- Sucursal -  TEXT --}}
                    <div class="form-group col-md-12 {{ $errors->first('store') ? 'has-error' : '' }}">

                        {{ Form::label('store', 'Sucursal', array('class' => 'col-md-4 control-label'))  }}
                        <div class="col-md-8">
                            {{ Form::text('store', $store->name, array('class' => 'form-control', 'placeholder' => '', 'id' => 'store', 'readonly' => '')) }}
                            {{ Form::hidden('hidden_store_id', $store->id, ['id' => 'hidden_store_id']) }}
                            @if( $errors->first('store'))
                                <p class="help-block">{{ $errors->first('store')  }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Barbero -  SELECT2 --}}
                    <div class="form-group col-md-12 {{ $errors->first('barber_id') ? 'has-error' : '' }}">

                        {{ Form::label('barber_id', 'Barbero', array('class' => 'col-md-4 control-label'))  }}
                        <div class="col-md-5">

                            <select placeholder="Barbero" class="select-select2" data-placeholder="Barbero" style="width: 100%;" id="barber_id">
                                <option value="pending">Sin asignar</option>
                                @foreach($barbers as $barber)
                                    <option value="{{ $barber->id }}">{{ $barber->first_name }} {{ $barber->last_name }}</option>
                                @endforeach
                            </select>

                            @if( $errors->first('barber_id'))
                                <span class="help-block">{{ $errors->first('barber_id')  }}</span>
                            @endif

                        </div>
                    </div>

                    {{ Form::hidden('appointment_date', null, ['id' => 'appointment-date']) }}


                    {{--  Hora de Inicio - TIME --}}
                    <div class="form-group col-md-12 {{ $errors->first('start') ? 'has-error' : '' }}">
                        <label class="col-md-4 control-label" for="start">Hora de Inicio</label>
                        <div class="col-md-8">
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
                    <div class="form-group col-md-12 {{ $errors->first('end') ? 'has-error' : '' }}">
                        <label class="col-md-4 control-label" for="end">Hora fin</label>
                        <div class="col-md-8">
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
                    <div class="form-group col-md-12 {{ $errors->first('services') ? 'has-error' : '' }}">

                        {{ Form::label('services', 'Servicios', array('class' => 'col-md-4 control-label'))  }}
                        <div class="col-md-8">

                            <select class="select-select2" placeholder="" data-placeholder="Servicios" style="width: 100%;" id="services" multiple>
                            @foreach($services as $service)
                                <option data-time="{{ $service->estimated_time }}" value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                            </select>

                            @if( $errors->first('services'))
                                <span class="help-block">{{ $errors->first('services')  }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Estatus de la cita -  SELECT2 --}}
                    <div class="form-group col-md-12 {{ $errors->first('status') ? 'has-error' : '' }}">

                        {{ Form::label('status', 'Estatus de la cita', array('class' => 'col-md-4 control-label'))  }}
                        <div class="col-md-8">
                            {{ Form::select('status', ['pending' => 'Pendiente de confirmar', 'confirmed' => 'Confirmada'], null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Estatus', 'style' => 'width: 100%;', 'id' => 'status')) }}

                            @if( $errors->first('status'))
                                <span class="help-block">{{ $errors->first('status')  }}</span>
                            @endif

                        </div>
                    </div>


                    {{-- FORM ACTIONS --}}
                    <div style="padding-top: 2em;" class="form-group form-actions col-md-12">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-effect-ripple btn-primary">Agendar cita</button>
                            {{ Form::button('Cancelar', array('data-dismiss' => 'modal', 'class' => 'btn btn-effect-ripple btn-danger', 'data-appointment-cancel-new' => '')) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>

            <div class="col-md-4">

                <div class="block">
                    <div class="block-title">
                        <h2>Buscador de Clientes</h2>
                    </div>
                    <div class="">
                        <fieldset>

                            {{-- Buscar cliente :  -  TEXT --}}
                            <div class="form-group">
                                <div id="autocomplete-customers">
                                    {{ Form::text('q', null, array('class' => 'form-control typeahead', 'placeholder' => 'Nombre, E-mail, Apodo', 'id' => 'q')) }}
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>

                <div class="block">
                    <div class="block-title">
                        <h2>Agregar cliente</h2>
                    </div>
                    <div class="">
                        {{ Form::open(['data-customer-create' => '', 'class' => '', 'route' => 'api.customers.store']) }}

                            {{-- Nombre -  TEXT --}}
                            <div class="form-group">
                                {{ Form::text('first_name', null, array('class' => 'form-control', 'placeholder' => 'Nombre', 'id' => 'first_name')) }}
                            </div>

                            {{-- Apellidos -  TEXT --}}
                            <div class="form-group">
                                {{ Form::text('last_name', null, array('class' => 'form-control', 'placeholder' => 'Apellido', 'id' => 'last_name')) }}
                            </div>

                            {{-- Apodo -  TEXT --}}
                            <div class="form-group">
                                {{ Form::text('aka', null, array('class' => 'form-control', 'placeholder' => 'Apodo', 'id' => 'aka')) }}
                            </div>


                            {{-- Fecha de nacimiento -  SELECT2 --}}
                            <div class="form-group">
                                {{ Form::select('birth_day', getDayOptions(), null, ['class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Día', 'style' => 'width: 25%;', 'id' => 'birth_day']) }}
                                    {{ Form::select('birth_month', getMonthOptions(), null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Mes', 'style' => 'width: 42%;', 'id' => 'birth_month')) }}
                                {{ Form::select('birth_year', getYearOptions(), null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Año', 'style' => 'width: 30%;', 'id' => 'birth_year')) }}
                            </div>

                            {{-- Email -  TEXT --}}
                            <div class="form-group">
                                {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email', 'data-email-validation' => 'inline')) }}
                            </div>

                            {{-- Enviar notificaciones por correo electrónico -  SWITCH --}}
                            <div style="display: none;" data-email-extra-data class="form-group">
                                <label class="switch switch-info">{{ Form::checkbox('send_email_notifications', 'true') }}<span></span></label>
                                <span class="help-block">Enviar notificaciones por correo electrónico.</span>
                                <br />
                                <label class="switch switch-info">{{ Form::checkbox('create_user_account', true, null) }}<span></span></label>
                                <span class="help-block">Crear cuenta de usuario para el cliente.</span>
                            </div>


                            {{-- Teléfono -  TEXT --}}
                            <div class="form-group">
                                {{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Teléfono', 'id' => 'phone')) }}
                            </div>


                            {{-- Celular -  TEXT --}}
                            <div class="form-group">
                                {{ Form::text('cellphone', null, array('class' => 'form-control', 'id' => 'cellphone', 'data-mobile-number' => '', 'data-phone-validation' => 'inline')) }}
                                {{ Form::hidden('cellphone_formatted', null,['data-mobile-number-formatted', 'id' => 'cellphone_formatted']) }}

                                <p class="help-block" data-cellphone-preview>

                                </p>
                            </div>

                            {{-- Enviar notificaciones por correo electrónico -  SWITCH --}}
                            <div {{ (empty($customer->cellphone) ? ' style="display: none;" ' : '' ) }}  data-phone-extra-data class="form-group">
                                <label class="switch switch-info">{{ Form::checkbox('send_cellphone_notifications', 'true') }}<span></span></label>
                                <span class="help-block">Enviar notificaciones por SMS.</span>
                            </div>

                            {{-- Notas -  TEXTAREA --}}
                            <div class="form-group">
                                {{ Form::textarea('notes', null, array('class' => 'form-control', 'rows' => 7,  'placeholder' => 'Notas', 'id' => 'notes')) }}
                            </div>


                            {{-- Barbero -  SELECT2 --}}
                            <div class="form-group">
                                <select name="barber_customer_id" id="barber_customer_id" class="select-select2" placeholder="Barbero" data-placeholder="Barbero de preferencia" style="width: 100%;">
                                    <option value="">Barbero de preferencia</option>
                                @foreach($barbers as $barber)
                                    <option value="{{ $barber->id }}">{{ $barber->first_name }} {{ $barber->last_name }}</option>
                                @endforeach
                                </select>
                            </div>

                            {{ Form::hidden('company_id', $company_id, ['id' => 'company_id']) }}

                            {{-- Crear cuenta de usuario -  SWITCH --}}
                            <!--div class="form-group">
                                <label class="switch switch-success">{{ Form::checkbox('user_create', 'true') }}<span></span></label>
                                <span class="help-block">¿Crear cuenta de usuario?</span>
                            </div-->

                            {{-- FORM ACTIONS --}}
                            <div  style="padding-top: 2em;" class="form-group form-actions">
                                <button type="submit" class="btn btn-effect-ripple btn-primary">Guardar</button>
                                {{ Form::reset('Cancelar', array('class' => 'btn btn-effect-ripple btn-danger')) }}
                            </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<div class="modal-footer">

</div>
