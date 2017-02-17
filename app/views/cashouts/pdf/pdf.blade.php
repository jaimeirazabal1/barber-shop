<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Corte de caja</title>
    <meta name="viewport" content="width=device-width" />
    <style type="text/css">
        @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .buttonwrapper { background-color: transparent !important; }
            body[yahoo] .button { padding: 0 !important; }
            body[yahoo] .button a { background-color: #777777; padding: 15px 25px !important; }
        }

        @media only screen and (min-device-width: 601px) {
            .content { width: 600px !important; }
            .col387 { width: 387px !important; }
        }

        .concept {
            margin: 20px 0 40px 0;
        }

        .concept h3 {
            margin: 0 0 0 0;
            line-height: 1em;
        }

        .concept p {
            margin-top: 0;
        }

    </style>

</head>
<body>

    <div style="text-align: center;">
        <img src="{{ public_path() }}/assets/admin/img/logo-medium.jpg" alt="Barber Shop">
    </div>

    <h2>Sucursal: {{ $store }}</h2>

    <p>
        <small><b>Realizado por:</b></small><br/>
        {{ $user }}
    </p>
    <p>
        <small><b>Periodo:</b></small><br />{{ $start }} - {{ $end }}
    </p>

    <div class="concept">
        <h3>Ventas Netas</h3>
        <table>
            <tr>
                <td>Caja inicial:</td>
                <td>${{ convertIntegerToMoney($initial_register) }}</td>
            </tr>
            <tr>
                <td>Ventas Efectivo:</td>
                <td>${{ convertIntegerToMoney($cash) }}</td>
            </tr>
            <tr>
                <td>Ventas tarjeta:</td>
                <td>${{ convertIntegerToMoney($card) }}</td>
            </tr>
            <tr>
                <td>Total:</td>
                <td><b>${{ convertIntegerToMoney($total + $initial_register) }}</b></td>
            </tr>
            <tr>
                <td>Propinas:</td>
                <td>
                    ${{ convertIntegerToMoney($tips) }}
                </td>
            </tr>
        </table>
    </div>

    <div class="concept">
        <h3>Total Retirado</h3>
        <table>
            <tr>
                <td>Total:</td>
                <td><b>${{ convertIntegerToMoney($withdraw) }}</b></td>
            </tr>
        </table>
    </div>

    <div class="concept">
        <h3>Total en caja</h3>
        <table>
            <tr>
                <td>Total:</td>
                <td><b>${{ convertIntegerToMoney($cash_left_on_register) }}</b></td>
            </tr>
        </table>
    </div>

</body>
</html>


