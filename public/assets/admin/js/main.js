$(function()
{

    var App = {
        getUrl: function() {
            return $('body').data('url');
        },
        getUrlApi: function()
        {
            return $('body').data('url-api');
        }
    }

    $(document).on('submit', '[data-destroy-resource]', function()
    {
        var $form = $(this),
            question = $form.data('destroy-resource-message') || null;

        if ( ! question)
        {
            question = 'El registro se eliminará permanentemente, ¿Deseas continuar?';
        }

        return confirm(question);
    });

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });

    $('[data-agenda-store="change"]').on('change', function(e)
    {
        var $select = $(this), value = $select.val();

        location.href = App.getUrl() + '/appointments?store=' + value;

    });

    $('[data-sales-store="change"]').on('change', function(e)
    {
        var $select = $(this), value = $select.val();

        location.href = App.getUrl() + '/sales?store=' + value;

    });


    $('[data-sales-product-add]').on('click', function(e)
    {
        e.preventDefault();

        var $productsList = $('[data-sales-product-option]'),
            $productsListContainer = $('[data-sales-product-list-added]'),
            $productAddButton = $(this);

        var $product = $productsList.find('option:selected'),
            product_name = $product.text(),
            product_price = $product.data('sales-product-price'),
            product_id   = parseInt($productsList.val(), 10) || 0;

            $productRow = $productsListContainer.find('tr[data-sales-product-item-list="' + product_id +'"]');

        var $html = [];



        var product_was_added = $productRow.length || false;

        var $productQty = null;

        if ( ! product_was_added && product_id)
        {
            $html.push('<tr data-sales-product-item-list="' + product_id + '">');
            $html.push('<td class="text-center" style="width: 40px;">');
            $html.push('<a data-sales-product-item-delete="' + product_id + '" href="javascript:void(0)" class="btn btn-effect-ripple btn-xs btn-danger pull-right"><i class="fa fa-times"></i></a>');
            $html.push('</td>');
            $html.push('<td style="width: 180px;">');
            //$html.push('<a href="#" title="Italian Pizza Night (2 People)">');
            $html.push(product_name);
            $html.push('<br /><small class="text-muted">' + Money.toHuman(product_price) + '</small>');
            //$html.push('</a>');
            $html.push('</td>');
            $html.push('<td style="width: 60px;" class="text-center">');
            $html.push('<input readonly="readonly" data-sales-product-qty type="text" class="form-control text-center" value="1">');
            $html.push('</td>');
            $html.push('<td style="width: 75px;" class="text-right">');
            $html.push('<strong data-sales-product-sub>' + Money.toHuman(product_price) + '</strong>');
            $html.push('</td>');
            $html.push('<td>');
            $html.push('<a data-sales-product-item-qty-add="' + product_id + '" class="btn btn-xs btn-success" href=""><i class="fa fa-plus"></i></a>');
            $html.push('<a data-sales-product-item-qty-minus="' + product_id + '" class="btn btn-xs btn-danger" href=""><i class="fa fa-minus"></i></a>');
            $html.push('</td>');
            $html.push('</tr>');

            $productsListContainer.append($html.join(''));

            $productRow = $('tr[data-sales-product-item-list="' + product_id + '"]');

            $productQty = $productRow.find('[data-sales-product-qty]');

            $('<input type="hidden" name="products[' + product_id + ']" id="sales-product-id-' + product_id + '" value="' + $productQty.val() + '">').appendTo($('form'));

        }
        else if (product_was_added)// El producto ya existe, se suma en 1 lo que tenga
        {
            $productQty = $productRow.find('[data-sales-product-qty]');
            var qty = parseInt($productQty.val(), 10);

            $productQty.val(qty + 1);
        }

        var $subtotalProducts = $('[data-sales-subtotal-products]');

        var subtotal_products = parseInt($subtotalProducts.data('subtotal'), 10);

        subtotal_products += (product_price);

        $subtotalProducts.data('subtotal', subtotal_products);
        $subtotalProducts.text(Money.toHuman(subtotal_products));

        $productRow.find('[data-sales-product-sub]').text(Money.toHuman($productQty.val() * product_price));


        $('#sales-product-id-' + product_id).val($productQty.val());

        calculateTotal();
    });

    $(document).on('click', '[data-sales-product-item-qty-add]', function(e)
    {
        e.preventDefault();

        console.log('add');

        var $btn = $(this),
            product_id = $btn.data('sales-product-item-qty-add'),
            $row = $('[data-sales-product-item-list="' + product_id + '"]'),
            $qty = $row.find('[data-sales-product-qty]'),
            qty  = parseInt($qty.val(), 10);

        $qty.val(qty + 1);

        var $productRow = $('[data-sales-product-list-added]').find('tr[data-sales-product-item-list="' + product_id +'"]'),
            $productQty = $productRow.find('[data-sales-product-qty]'),
            qty         = parseInt($productQty.val(), 10);


        var $subtotalProducts = $('[data-sales-subtotal-products]');

        var subtotal_products = parseInt($subtotalProducts.data('subtotal'), 10);

        var product_price = parseInt($('[data-sales-product-option]').find('option[value="' + product_id + '"]').data('sales-product-price'), 10);

        subtotal_products += (product_price);

        $subtotalProducts.data('subtotal', subtotal_products);
        $subtotalProducts.text(Money.toHuman(subtotal_products));

        $productRow.find('[data-sales-product-sub]').text(Money.toHuman($productQty.val() * product_price));


        $('#sales-product-id-' + product_id).val(qty);

        calculateTotal();

    });

    $(document).on('click', '[data-sales-product-item-qty-minus]', function(e)
    {
        e.preventDefault();

        console.log('minus');

        var $btn = $(this),
            product_id = $btn.data('sales-product-item-qty-minus'),
            $row = $('[data-sales-product-item-list="' + product_id + '"]'),
            $qty = $row.find('[data-sales-product-qty]'),
            qty  = parseInt($qty.val(), 10);

        if ( qty > 1)
        {
            $qty.val(qty - 1);

            var $productRow = $('[data-sales-product-list-added]').find('tr[data-sales-product-item-list="' + product_id +'"]'),
                $productQty = $productRow.find('[data-sales-product-qty]'),
                qty         = parseInt($productQty.val(), 10);


            var $subtotalProducts = $('[data-sales-subtotal-products]');

            var subtotal_products = parseInt($subtotalProducts.data('subtotal'), 10);

            var product_price = parseInt($('[data-sales-product-option]').find('option[value="' + product_id + '"]').data('sales-product-price'), 10);

            subtotal_products -= (product_price);

            $subtotalProducts.data('subtotal', subtotal_products);
            $subtotalProducts.text(Money.toHuman(subtotal_products));

            $productRow.find('[data-sales-product-sub]').text(Money.toHuman($productQty.val() * product_price));

            $('#sales-product-id-' + product_id).val(qty);

            calculateTotal();

        }
    });


    $(document).on('click', '[data-sales-product-item-delete]', function(e)
    {
        e.preventDefault();

        var $btn = $(this),
            product_id = $btn.data('sales-product-item-delete'),
            $row = $('[data-sales-product-item-list="' + product_id + '"]');


        var $productRow = $('[data-sales-product-list-added]').find('tr[data-sales-product-item-list="' + product_id +'"]'),
            $productQty = $productRow.find('[data-sales-product-qty]'),
            qty         = parseInt($productQty.val(), 10);


        var $subtotalProducts = $('[data-sales-subtotal-products]');

        var subtotal_products = parseInt($subtotalProducts.data('subtotal'), 10);

        var product_price = parseInt($('[data-sales-product-option]').find('option[value="' + product_id + '"]').data('sales-product-price'), 10);

        subtotal_products -= (qty * product_price);

        $subtotalProducts.data('subtotal', subtotal_products);
        $subtotalProducts.text(Money.toHuman(subtotal_products));

        $productRow.find('[data-sales-product-sub]').text(Money.toHuman($productQty.val() * product_price));

        $('#sales-product-id-' + product_id).remove();

        $row.fadeOut('normal', function()
        {
            $(this).remove();
        });

        calculateTotal();

    });


    function calculateTotal()
    {
        var total = 0,
            $subtotalServices = $('[data-sales-subtotal-services]'),
            $subtotalProducts = $('[data-sales-subtotal-products]'),
            subtotalServices  = parseInt($subtotalServices.data('subtotal'), 10) || 0,
            subtotalProducts  = parseInt($subtotalProducts.data('subtotal'), 10) || 0;

        console.log(subtotalProducts);
        console.log(subtotalServices);

        total = (subtotalProducts + subtotalServices);

        $('#total').val(Money.number_format(Money.toPesos(total), 2));
    }


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
            return '$ ' + Money.number_format(this.toPesos(number), 2);
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



    $('[data-add-service]').on('click', function(e){
        e.preventDefault();

        var $select = $('[data-service-options]');

        //var exist_slider = $('[data-service-slider-' + $select.val() + ']').length;
        var exist_slider = $('[data-service-id="' + $select.val() + '"]').length;

        if ($select.val() != '' && exist_slider == 0)
        {
            var $service = new Array();

            //var $slider = 'data-service-slider-' + $select.val();


            $service.push('<div class="form-group" data-service-id="' + $select.val() + '">');
            $service.push('<label class="col-md-8 col-md-offset-4"><a data-service-destroy="' + $select.val() + '" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar"><i class="fa fa-times"></i></a> ');
            $service.push($select.find('option:selected').text());
            $service.push('</label>');
            $service.push('<input type="hidden" value="30" name="services[' +  $select.val() + ']" />');
            /*$service.push('<div class="col-md-8">');
            $service.push('<span class="help-block">Tiempo por servicio (minutos)</span>');
            $service.push('<div class="input-slider-info">');
            $service.push('<input ' + $slider + ' type="text" name="services[' +  $select.val() + ']" class="form-control input-slider" data-slider-min="1" data-slider-max="60" data-slider-step="1" data-slider-value="0" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show">');
            $service.push('</div>');
            $service.push('</div>');*/
            $service.push('</div>');

            $service = $service.join('');


            $($service).insertBefore('[data-service-before-insert]').hide().fadeIn();

            //$('[' + $slider + ']').slider();
        }
        else if (exist_slider)
        {
            alert('El servicio ya se ha agregado');
        }
        else
        {
            alert('Selecciona un servicio');
        }
    });


    $(document).on('click', '[data-service-destroy]', function(e)
    {
        e.preventDefault();

        var $btn = $(this);


        var id = $btn.data('service-destroy');

        if (confirm('¿Deseas eliminar este servicio?'))
        {
            $('[data-service-id=' + id + ']').fadeOut('normal', function(){
                $(this).remove();
            });
        }

    });

    function validateEmail(value)
    {
        // From https://html.spec.whatwg.org/multipage/forms.html#valid-e-mail-address
        // Retrieved 2014-01-14
        // If you have a problem with this implementation, report a bug against the above spec
        // Or use custom methods to implement your own email validation
        return /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test( value );

    }

    $('[data-email-validation="inline"]').on('change', function(e)
    {
        e.preventDefault();

        var $input = $(this),
            value = $input.val(),
            $extraData = $('[data-email-extra-data]');

        console.log(value);

        if (validateEmail(value))
        {
            console.log('mostrar extra');
            $extraData.slideDown();
        }
        else
        {
            console.log('ocultar extra');
            $extraData.slideUp();
        }
    });

    $('[data-phone-validation="inline"]').on('change', function(e)
    {
        e.preventDefault();

        var $input = $(this),
            value = $input.val() || '',
            $extraData = $('[data-phone-extra-data]');

        console.log(value);

        if (value.trim() != '')
        {
            $extraData.slideDown();
        }
        else
        {
            $extraData.slideUp();
        }
    });

    $('[data-mobile-number]').on('change', function(e)
    {
        var $preview = $('[data-cellphone-preview]'),
            international_number = $('[data-mobile-number]').intlTelInput("getNumber", intlTelInputUtils.numberFormat.INTERNATIONAL);

        $('[data-mobile-number-formatted]').val(international_number);
        $preview.text(international_number);
    });


    $("[data-mobile-number]").intlTelInput({
        defaultCountry: 'mx',
        nationalMode: true,
        numberType: 'MOBILE',
        onlyCountries: [
            'mx'
        ],
        utilsScript: ($('body').data('url') + '/vendors/intl-tel-input/utils.js')

    });

    $('[data-schedule]').on('change', function(e)
    {
        var $check = $(this),
            day = $check.data('schedule'),
            $checkData = $('[data-schedule-info="' + day + '"]');

        if ($check.is(':checked'))
        {
            $checkData.slideDown();
        }
        else
        {
            $checkData.slideUp();
        }
    });


});