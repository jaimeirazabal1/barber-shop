{{--Fecha de Inicio -  TEXT --}}
<div class="form-group {{ $errors->first('date_start') ? 'has-error' : '' }}">

    {{ Form::label('date_start', 'Fecha de Inicio', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('date_start', empty($date_start) ? null : $date_start, array('class' => 'form-control', 'placeholder' => '', 'id' => 'date_start', 'disabled' => true)) }}
        @if( $errors->first('date_start'))
            <p class="help-block">{{ $errors->first('date_start')  }}</p>
        @endif
    </div>
</div>

{{-- Fecha de Fin -  TEXT --}}
<div class="form-group {{ $errors->first('date_end') ? 'has-error' : '' }}">

    {{ Form::label('date_end', 'Fecha de Fin', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('date_end', empty($date_end) ? null : $date_end, array('class' => 'form-control', 'placeholder' => '', 'id' => 'date_end', 'disabled' => true)) }}
        @if( $errors->first('date_end'))
            <p class="help-block">{{ $errors->first('date_end')  }}</p>
        @endif
    </div>
</div>



<table class="table table-striped">

    <thead>
        <tr>
            <th>Método de pago</th>
            <th>Esperado</th>
            <th>&nbsp;</th>
            <th>Contado</th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <td>Caja inicial</td>
            <td>
                <span>{{ empty($latest_cashout) ? convertIntegerToMoney(0) : convertIntegerToMoney($latest_cashout->cash_left_on_register) }}</span>
                {{ Form::hidden('last_cash_left_on_register', empty($latest_cashout) ? 0 : $latest_cashout->cash_left_on_register) }}
            </td>
            <td>

            </td>
            <td>
                -
            </td>
        </tr>

        <tr>
            <td>Efectivo</td>
            <td>{{ convertIntegerToMoney($total_cash) }}</td>
            <td>
                <a data-cashout-cash-btn-ok class="btn btn-xs btn-success btn-effect-ripple" href="#"><i class="fa fa-check"></i></a>
                <!--a data-cashout-cash-btn-edit class="btn btn-xs btn-warning btn-effect-ripple" href="#"><i class="fa fa-pencil"></i></a-->
            </td>
            <td>
                <span>
                    <span data-cashout-cash-price-label="{{ ($total_cash) }}" style="display: none;">{{ convertIntegerToMoney($total_cash) }}</span>
                    <span  style="display: none;" data-cashout-cash-price-input-label><input type="text" data-cashout-cash-price-input-edit="{{ ($total_cash) }}" value="{{ convertIntegerToMoney($total_cash) }}"> <button data-cashout-cash-price-input-btn-edit-ok class="btn btn-xs btn-success">ok</button></span>
                    <input data-counted-cash name="money_on_cash" type="hidden" value="">
                </span>
            </td>
        </tr>

        <tr>
            <td>Tarjeta</td>
            <td>{{ convertIntegerToMoney($total_card) }}</td>
            <td>
                <a data-cashout-card-btn-ok class="btn btn-xs btn-success btn-effect-ripple" href="#"><i class="fa fa-check"></i></a>
                <!--a data-cashout-card-btn-edit class="btn btn-xs btn-warning btn-effect-ripple" href="#"><i class="fa fa-pencil"></i></a-->
            </td>
            <td>
                <span>
                    <span data-cashout-card-price-label="{{ ($total_card) }}" style="display: none;">{{ convertIntegerToMoney($total_card) }}</span>
                    <span style="display: none;" data-cashout-card-price-input-label><input  type="text" data-cashout-card-price-input-edit="{{ ($total_card) }}" value="{{ convertIntegerToMoney($total_card) }}"> <button data-cashout-card-price-input-btn-edit-ok class="btn btn-xs btn-success">ok</button></span>
                    <input data-counted-card name="money_on_card" type="hidden" value="">
                </span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

    </tbody>

    <tfoot>
        <tr>
            <td><b>Total</b></td>
            <td>{{ convertIntegerToMoney($total_cash + $total_card + (empty($latest_cashout) ? 0 : $latest_cashout->cash_left_on_register)) }}</td>
            <td></td>
            <td class="text-danger"><span data-cashout-total-counted-original="-{{ ($total_cash + $total_card) }}" data-cashout-total-counted="-{{ ($total_cash + $total_card) }}">-{{ convertIntegerToMoney($total_cash + $total_card) }}</span></td>
        </tr>

        <tr>
            <td>Propinas</td>
            <td>
                {{ convertIntegerToMoney($tips) }}
                {{ Form::hidden('tips', $tips) }}
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>

</table>


{{-- Cantidad a dejar en la caja -  TEXT --}}
<div class="form-group {{ $errors->first('cash_left_on_register') ? 'has-error' : '' }}">

    {{ Form::label('cash_left_on_register', 'Cantidad a dejar en caja', array('class' => 'col-md-4 control-label'))  }}
    <div class="col-md-8">
        {{ Form::text('cash_left_on_register', null, array('class' => 'form-control', 'placeholder' => '0.00', 'id' => 'cash_left_on_register')) }}
        @if( $errors->first('cash_left_on_register'))
            <p class="help-block">{{ $errors->first('cash_left_on_register')  }}</p>
        @endif

        {{ Form::hidden('start', $date_start) }}
        {{ Form::hidden('end', $date_end) }}
        {{ Form::hidden('store_id', $store_id) }}
    </div>
</div>

{{-- FORM ACTIONS --}}
<div class="form-group form-actions">
    <div class="col-md-8 col-md-offset-4">
        {{ Form::submit('Realizar corte de caja', array('class' => 'btn btn-effect-ripple btn-primary')) }}
    </div>
</div>