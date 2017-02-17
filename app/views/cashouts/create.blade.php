@extends('layouts.master')


@section('title', 'Cortes de caja')


@section('content')

<!-- Section Header -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>
                    Cortes de caja
                    <small class="label label-primary">{{ (empty($store) ? 'Generales' : $store->name) }}</small>
                </h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li>{{ link_to_route('app.dashboard', 'Dashboard', $company) }}</li>
                    <li>{{ link_to_route('cashout.index','Cortes de cajas', [$company, 'store' => $store->id]) }}</li>
                    <li>Agregar</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END Section Header -->


<!-- Row -->
<div class="row">
    <div class="col-md-8">
        <!-- Block -->
        <div class="block">

            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2>Corte de caja</h2>
                <div class="block-options pull-right">
                    <a href="{{ route('cashout.index', [$company, 'store' => $store_id]) }}" class="btn btn-effect-ripple btn-default" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Volver al listado"><i class="fa fa-chevron-circle-left"></i> Volver al listado</a>
                </div>
            </div>
            <!-- END Horizontal Form Title -->


            <!-- Form Content -->
            {{ Form::open(array('method' => 'POST', 'route' => ['cashout.store', $company], 'class' => 'form-horizontal form-bordered', 'data-form-cashout' => ''))  }}

                @include('cashouts.partials._form')

            {{ Form::close() }}
            <!-- END Form Content -->


        </div>
        <!-- END Block -->

    </div>
</div>
<!-- END Row -->


@stop


@section('javascript')
<!-- ckeditor.js, load it only in the page you would like to use CKEditor (it's a heavy plugin to include it with the others!) -->
{{ HTML::script('assets/admin/js/plugins/ckeditor/ckeditor.js') }}

<!-- Load and execute javascript code used only in this page -->
{{ HTML::script('assets/admin/js/pages/formsComponents.js') }}
<script>$(function(){ FormsComponents.init(); });</script>

<script>
    $(function()
    {

        var Money = {
            number_format: function(number, decimals, dec_point, thousands_sep){
                number = (number + '')
                        .replace(/[^0-9+\-Ee.]/g, '');
                var n = !isFinite(+number) ? 0 : +number,
                        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                        s = '',
                        toFixedFix = function(n, prec) {
                            var k = Math.pow(10, prec);
                            return '' + (Math.round(n * k) / k)
                                            .toFixed(prec);
                        };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
                        .split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '')
                                .length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1)
                            .join('0');
                }
                return s.join(dec);
            },
            toPesos: function(number){
                return number / 100;
            },
            toHuman: function(number){
                return Money.number_format(this.toPesos(number), 2);
            },
            toInteger: function(number){
                try
                {
                    number = parseFloat(number.replace(/[^0-9\.]/g, '')) * 100;
                    console.log(number);
                }
                catch(e)
                {
                    console.log('El número es inválido');
                    number = 0;
                }

                return number;
            },
            isValid: function(number){
                var $regex1 = /^[0-9]{1,3}(,[0-9]{3})*(\.[0-9]+)?$/,
                        $regex2 = /^[0-9]+(\.[0-9]+)?$/;

                if ($regex1.test(number) || $regex2.test(number))
                {
                    console.log('valido');
                    return true;
                }

                console.log('invalido');
                return false;
            }
        };

        var $btnCashOk = $('[data-cashout-cash-btn-ok]'),
            $btnCardOk = $('[data-cashout-card-btn-ok]'),
                    $btnCashEdit = $('[data-cashout-cash-btn-edit]'),
                    $btnCardEdit = $('[data-cashout-card-btn-edit]'),
                    $labelCash = $('[data-cashout-cash-price-label]'),
                    $labelCard = $('[data-cashout-card-price-label]'),
                    $labelInputCash = $('[data-cashout-cash-price-input-label]'),
                    $labelInputCard = $('[data-cashout-card-price-input-label]'),
                    $inputCashEdit = $('[data-cashout-cash-price-input-edit]'),
                    $inputCardEdit = $('[data-cashout-card-price-input-edit]'),
                    $btnInputCashEditOk = $('[data-cashout-cash-price-input-btn-edit-ok]'),
                    $btnInputCardEditOk = $('[data-cashout-card-price-input-btn-edit-ok]'),
                    $inputCash = $('[data-counted-cash]'),
                    $inputCard = $('[data-counted-card]'),
                    $totalCountedOriginal = $('[data-cashout-total-counted-original]'),
                    $totalCountedEditable = $('[data-cashout-total-counted]');

        $btnCashOk.on('click', function(e)
        {
            e.preventDefault();

            $btnCashOk.hide();
            $labelCash.show();
            var value = $inputCashEdit.data('cashout-cash-price-input-edit');
            $inputCash.val(value);

            setTotalCounted();
        });

        $btnCardOk.on('click', function(e)
        {
            e.preventDefault();

            $btnCardOk.hide();
            $labelCard.show();
            var value = $inputCardEdit.data('cashout-card-price-input-edit');
            $inputCard.val(value);

            setTotalCounted();
        });

        $btnCashEdit.on('click', function(e)
        {
            e.preventDefault();

            $btnCashOk.hide();
            $labelCash.hide();
            $labelInputCash.show();
        });

        $btnCardEdit.on('click', function(e)
        {
            e.preventDefault();

            $btnCardOk.hide();
            $labelCard.hide();
            $labelInputCard.show();
        });

        $btnInputCashEditOk.on('click', function(e)
        {
            e.preventDefault();

            $labelInputCash.hide();
            var value = $inputCashEdit.val();
            var valueInteger = Money.toInteger(value);
            $inputCashEdit.data('cashout-cash-price-input-edit', valueInteger);


            $inputCash.val(valueInteger);
            $labelCash.text(Money.toHuman(valueInteger)).show();

             setTotalCounted();
        });

        $btnInputCardEditOk.on('click', function(e)
        {
            e.preventDefault();

            $labelInputCard.hide();
            var value = $inputCardEdit.val();
            var valueInteger = Money.toInteger(value);
            $inputCardEdit.data('cashout-card-price-input-edit', valueInteger);

            $inputCard.val(valueInteger);
            $labelCard.text(Money.toHuman(valueInteger)).show();

            setTotalCounted();
        });


        function setTotalCounted()
        {
            var totalCounted = $totalCountedOriginal.data('cashout-total-counted-original'),
                    newMount = (parseInt(totalCounted, 10) || 0) + (parseInt($inputCash.val(), 10) || 0) + (parseInt($inputCard.val(), 10) || 0);

            if (newMount >= 0 )
            {
                $totalCountedOriginal.parent().removeClass('text-danger');
            }
            else
            {
                $totalCountedOriginal.parent().addClass('text-danger');
            }
            $totalCountedOriginal.text(Money.toHuman(newMount));
        }

        $('[data-form-cashout]').on('submit', function(e)
        {
            if (confirm('Esta a punto de generarse el corte de caja. ¿Deseas continuar?'))
            {
                return true;
            }
            else
            {
                return false;
            }
        });

    });
</script>
@stop