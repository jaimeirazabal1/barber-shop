<?php

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
*/
// TODO : Actualizar api con todos los cambios decategorias, tag, servicios y productos
// TODO : Modulo de configuracion para SMS
// TODO : Integrar JWT
// TODO : Corte de caja
// TODO : reportes del sistema
// TODO : al confirmar la cita notificar por sms y correo electrónico
// TODO : enviar datos de la cuenta de usuario recien creada
// TODO : programar cronjob para cambiar el estatus a las citas que no se realizaron
// TODO : Crear tabla de comisiones para el pago de sueldos de barbero
// TODO : Afectar inventario de los productos desde el módulo de ventas, que pasa si hay 0 productos ?
// TODO : Importar inventario de productos


// TODO : Agregar filtros de permisos para los modulos restantes (barbers, users, etc)


/**
 *
1.-Anteriormente habías puesto en citas, seleccionar la fecha por si la cita se quería reagendar para otro día,
 * pero si el día siguiente esta lleno de citas y no sabemos los espacios sin citas creemos que la mejor
 * forma de solucionarlo es lo siguiente:
Cuando se abre la ventana de editar cita, si seleccionas barbero y fecha, te aparezca los horarios libres
 * que tiene ese barbero esa fecha, ejemplo te saldría solo los horarios de 9.00, 11.30, 12.00, 14:00 etc y ya
 * asi yo le doy click a la hr y ya no se traslaparía con ninguna otra cita de el, por que de otra manera cuando quiero
 * agendar una cita otro día no tengo la manera de saber que horas tiene libre ese barbero a menos que me salga de esa
 * sección de editar cita, (adjunto foto). NECESITARIA QUE ME AGREGARAS LOS HORARIOS DE ESE DIA QUE ESCOJISTE, Y LOS 2 DIAS PROXIMOS.



================== NO ES POSIBLE REALIZAR ESTE PUNTO ===========
3.-En la seccion de barberos, cambiaste la hr de entrada por la hr de comida, pero para el chocador en la sección de barbero, debes de dejar
Entrada - hr
Comida - Hr inicio - hr fin
Salida - hr

y en citas no puedas agendar citas a la hr de comida que tiene asignado este barbero, así como ni antes de su hr de inicio ni
 * después de su hr de salida. y en la sección de citas cuando te salgan los horarios disponibles obvio que no salgan las horas
 * antes de inicio de labor, ni durante su comida ni después de hr de salida ( si se pudiera dejar en la agenda un espacio en
 * rojo en su hr de comida seria lo ideal pero eso ya me diras que tan sencillo o difícil es)





 */

/**

SECCION DE SUELDOS Y COMISIONES

-Ventas por barbero
Tabla de comisiones
$0 - $6,999 	- 15%
$7000 - $7999 - 17%
$8000 - $8999	- 19%
$9000 - $9999 - 21%
$10000 - $11999 - 22%
$12000 - $14999 - 24%
$15000 - $15999 - 28%
mas $16000		30%


Barbero Pepe $800.00
 * Lunes      vacaciones - 133.33 - a pagar
 * Martes     retardo    - 133.33 - descontar 1%
 * Miercoles  falta justificada    - 133.33 - a pagar
 * Jueves     falta injustificada    - 133.33 - descontar sueldo del dia - descontar 1%
 * Viernes    asistencia    - 133.33 - a pagar
 * Sábado     asistencia    - 133.33 - a pagar
 *

Barbero Toño
 * Lunes      asistencia - pagar
 * Martes     asistencia - pagar
 * Miercoles  retardo - descontar 1%
 * Jueves     falta injustificada - descontar dia - descontar 1%
 * Viernes    asistencia - pagar
 * Sábado     asistencia - pagar


Barbero Ramón
 * Lunes      retardo - descontar 1%
 * Martes     falta justificada - pagar
 * Miercoles  retardo - descontar 1%
 * Jueves     falta injustificada - descontar dia - descontar 1%
 * Viernes    asistencia - pagar
 * Sábado     falta injustificada - descontar dia - descontar 1%
 *

Barbero Miguel
 * Lunes      asistencia - pagar
 * Martes     asistencia - pagar
 * Miercoles  asistencia - pagar
 * Jueves     asistencia - pagar
 * Viernes    asistencia - pagar
 * Sábado     retardo - descontar 1%
 *

 *Obtener el horario de la sucursal y ver la hora de entrada limite por día(lunes, martes, etc...)
 * Determinar en que dia se encuentra al momento de ver el reporte de nomina
 * Si se selecciona el filtro de fechas de inicio a fin entonces calcula el reporte en base a la fecha elegida
 * Si no, se determina la semana actual (de lunes a sabado jornada laboral) y se calcula el reporte
 * Genera el reporte al vuelo, por cada barbero va generando el reporte
 * por cada barbero obtiene los dias laborados de la jornada laboral
 * ¿Como saber como se justifican las faltas, de que manera se van a justificar?

¿Qué pasa cuando un barbero falta en los días de la semana?, ¿Cómo afecta a su sueldo?
Hay 3 tipos de inasistencias
1.-Vacaciones
2.-Falta Justificada
3.- Injustificada

La 1 y 2 no afecta la falta al sueldo. La 3, por cada falta se descuenta 1% de sus
 * comisiones( ósea si tenia 15% de comisiones, con 1 falta tendrá 14%) y aparte se le descontara
 * 1 día de sueldo.
 *
 *
 * Definir por sucursal el rango de jornada laboral de que día a que día
 *
 * El salario por dia es de (sueldo semanal 800 / 6 dias de la semana)

Retardos - La hr de entrada de los barberos es de Lunes a Viernes a las 11am y sábados a las 10am.
 * Si llegan a las 11.01 o 10.01, se les descuenta un 1% de sus comisiones(como ejemplo de arriba)

La jornada laboral es de Lunes a Sabado y el sueldo es semanal


 */


/*
 * CORTE DE CAJA
 *
 * - Obtener todos los pagos pendientes y decidir con el usuario si se borran o se ponen como pagados
 * -
 *
 */


/*
 * Si se traslapan una cita con la hora deseada entonces devuelve resultados, si no se translapan, devuelve 0 resultados
 * SELECT * FROM appointments WHERE '2015-09-07 09:00:00' < end AND '2015-09-07 11:00:00' > start and barber_id = 3;
 *
 * */

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/
$domain = 'ascbarbershop.ascmexico.net';


Route::group(['prefix' => 'api', 'domain' => 'ascbarbershop.ascmexico.net'], function()
{
    Route::get('/', ['as' => 'api.index', 'uses' => '\Api\ApiController@notindex']);
    Route::resource('users', '\Api\V1\UsersController', ['except' => ['create', 'edit', 'destroy']]);
    Route::resource('companies', '\Api\V1\CompaniesController', ['except' => ['create', 'edit', 'destroy']]);
    Route::resource('stores', '\Api\V1\StoresController', ['except' => ['create', 'edit', 'destroy']]);
    Route::resource('barbers', '\Api\V1\BarbersController', ['except' => ['create', 'edit', 'destroy']]);
    Route::resource('services', '\Api\V1\ServicesController', ['except' => ['create', 'edit', 'destroy']]);
    Route::resource('products', '\Api\V1\ProductsController', ['except' => ['create', 'edit', 'destroy']]);
    Route::resource('customers', '\Api\V1\CustomersController', ['except' => ['create', 'edit', 'destroy']]);
    Route::resource('customers.services', '\Api\V1\CustomersServicesController', ['except' => ['create', 'edit']]);
    Route::resource('checkins', '\Api\V1\CheckinsController', ['except' => ['create', 'edit', 'destroy', 'update']]);
    Route::resource('appointments', '\Api\V1\AppointmentsController', ['except' => ['create', 'edit']]);
    Route::resource('appointments.services', '\Api\V1\AppointmentsServicesController', ['except' => ['create', 'edit']]);
});


/*
|--------------------------------------------------------------------------
| App Routes
|--------------------------------------------------------------------------
|
*/

Route::group(array('before' => ['getSubdomain'], 'domain' => '{company}.ascbarbershop.ascmexico.net'), function()
{
    Route::get('login', ['as' => 'sessions.create', 'uses' => 'SessionsController@create']);
    Route::post('login', ['as' => 'sessions.store', 'uses' => 'SessionsController@store']);
    Route::get('password-recovery', ['as' => 'sessions.password-recovery', 'uses' => 'SessionsController@passwordRecovery']);
    Route::post('password-recovery', ['as' => 'sessions.password-recovery.post', 'uses' => 'SessionsController@passwordRecoverySend']);
    Route::get('password-reset/{email}/{token}', ['as' => 'sessions.password-reset', 'uses' => 'SessionsController@passwordReset']);
    Route::post('password-reset/{email}/{token}', ['as' => 'sessions.password-reset.post', 'uses' => 'SessionsController@passwordResetSend']);
    Route::get('logout', ['as' => 'sessions.destroy', 'uses' => 'SessionsController@destroy']);
    Route::get('forbidden', array('as' => 'sessions.forbidden', 'uses' => 'SessionsController@forbidden'));
});

Route::group(array('before' => ['getSubdomain', 'auth.sentry'], 'domain' => '{company}.ascbarbershop.ascmexico.net'), function()
{
    Route::get('/', ['as' => 'app.dashboard', 'uses' => 'DashboardController@index']);
    Route::resource('appointments', 'AppointmentsController');
    Route::resource('sales', 'SalesController', ['except' => ['show', 'destroy']]);

    Route::post('/sales/add_service/{appointment_id_}/{service_id}/{time}','SalesController@add_service');

    Route::resource('stores', 'StoresController', ['except' => ['destroy']]);
    Route::resource('barbers', 'BarbersController', ['except' => ['destroy', 'show']]);
    Route::resource('barbers.checkins', 'BarbersCheckinsController', ['except' => ['create', 'store', 'destroy', 'show']]);
    Route::resource('customers', 'CustomersController', ['except' => ['destroy', 'show']]);
    Route::resource('category-services', 'CategoryServicesController', ['except' => ['destroy', 'show']]);
    Route::resource('tag-services', 'TagServicesController', ['except' => ['destroy', 'show']]);
    Route::resource('services', 'ServicesController', ['except' => ['destroy', 'show']]);
    Route::resource('category-products', 'CategoryProductsController', ['except' => ['destroy', 'show']]);
    Route::resource('tag-products', 'TagProductsController', ['except' => ['destroy', 'show']]);
    Route::resource('products', 'ProductsController', ['except' => ['destroy', 'show']]);
    Route::resource('suppliers', 'SuppliersController', ['except' => ['destroy', 'show']]);
    Route::resource('users', 'UsersController', ['except' => ['show', 'destroy']]);
    Route::get('{store}/checador', ['as' => 'app.timeclock.create', 'uses' => 'StoreCheckinController@create']);

    Route::resource('payroll', 'PayrollController', ['except' => ['show', 'destroy']]);
    Route::post('cashout/pdf', ['as' => 'cashout.pdf', 'uses' => 'CashoutsController@pdf']);
    Route::resource('cashout', 'CashoutsController', ['except' => ['show', 'destroy']]);

    Route::get('reports/generate',['as' => 'reports.generate', 'uses' => 'ReportsController@generate']);
    Route::get('reports/show',['as' => 'reports.show', 'uses' => 'ReportsController@show']);
    Route::get('reports/inventory',['as' => 'reports.inventory', 'uses' => 'ReportsController@inventory']);
    Route::get('reports/customer-count-attended',['as' => 'reports.numero-clientes-atendidos', 'uses' => 'ReportsController@attendedCustomerCounter']);
    Route::get('reports/services-by-day',['as' => 'reports.servicios-por-dia', 'uses' => 'ReportsController@servicesByDay']);
    Route::get('reports/amount-sales-by-service',['as' => 'reports.importe-de-ventas-de-servicios', 'uses' => 'ReportsController@salesAmountByService']);
    Route::get('reports/amount-sales-by-product',['as' => 'reports.importe-de-ventas-de-productos', 'uses' => 'ReportsController@salesAmountByProduct']);
    Route::get('reports/best-product-sellers',['as' => 'reports.productos-mas-vendidos', 'uses' => 'ReportsController@bestProductSellers']);
    Route::get('reports/average-time-by-service',['as' => 'reports.tiempo-promedio-por-servicio', 'uses' => 'ReportsController@averageTimeByService']);
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/



Route::get('admin/login', ['as' => 'admin.sessions.create', 'uses' => '\Admin\SessionsController@create']);
Route::post('admin/login', ['as' => 'admin.sessions.store', 'uses' => '\Admin\SessionsController@store']);


Route::get('admin/password-recovery', ['as' => 'admin.sessions.password-recovery', 'uses' => '\Admin\SessionsController@passwordRecovery']);
Route::post('admin/password-recovery', ['as' => 'admin.sessions.password-recovery.post', 'uses' => '\Admin\SessionsController@passwordRecoverySend']);
Route::get('admin/password-reset/{email}/{token}', ['as' => 'admin.sessions.password-reset', 'uses' => '\Admin\SessionsController@passwordReset']);
Route::post('admin/password-reset/{email}/{token}', ['as' => 'admin.sessions.password-reset.post', 'uses' => '\Admin\SessionsController@passwordResetSend']);
Route::get('admin/logout', ['as' => 'admin.sessions.destroy', 'uses' => '\Admin\SessionsController@destroy']);
Route::get('admin/forbidden', array('as' => 'admin.sessions.forbidden', 'uses' => '\Admin\SessionsController@forbidden'));

Route::group(['before' => 'auth.admin.sentry', 'prefix' => 'admin'], function()
{
    Route::get('/', ['as' => 'admin.dashboard', 'uses' => '\Admin\DashboardController@index']);

    # Users
    Route::resource('users', '\Admin\UsersController', ['except' => ['show', 'destroy']]);
});
// TODO : cuando de la cita se genera la venta el estatus en el calendario sigue en pendiente y no pasa a proceso
// TODO : al generar una cita, si guardo una y despues guardo otra vacia de todos modos permite guardarla

Route::get('corte', function()
{
    $last_cut = '2015-10-12 21:48:50';
    $date_start = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $last_cut)->addSecond();
    //$time = round(($date_last->timestamp / 60)) * 60;

    $date_end = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2015-10-12 21:55:38');# Carbon now

    $store_id = 1;

    # Ventas pagadas del día a la fecha de corte
    $sales = Sale::with('appointment.services', 'products')->onDatetime($date_start->toDateTimeString(), $date_end->toDateTimeString())->paid()->byStore($store_id)->get();



    $total_sales = [
        'cash' => [
            'products' => 0,
            'services' => 0
        ],
        'card' => [
            'products' => 0,
            'services' => 0
        ]
    ];

    // TODO : el precio de servicio debe ser almacenado en appointment_service ya que el precio puede cambiar
    foreach($sales as $sale)
    {
        $total_sale_services = 0;
        $total_sale_products = 0;

        foreach($sale->appointment->services as $service)
        {
            $total_sale_services += $service->price;
        }

        foreach($sale->products as $product)
        {
            $total_sale_products += ($product->pivot->price * $product->pivot->quantity);
        }

        switch($sale->type)
        {
            case 'cash':
                $total_sales['cash']['products'] += $total_sale_products;
                $total_sales['cash']['services'] += $total_sale_services;
                break;
            case 'card':
                $total_sales['card']['products'] += $total_sale_products;
                $total_sales['card']['services'] += $total_sale_services;
                break;
        }
    }

    #return $total_sales;

    # El IVA solo aplica a productos
    /*$iva = [
        'cash' => (integer) round(($total_sales['cash']['products'] * 1.16)),
        'card' => (integer) round(($total_sales['card']['products'] * 1.16))
    ];*/

    #return $iva;

    return $total_sales;

    return $sales;

    # Ventas pendientes del día a la fecha de corte
    $sales_pending = Sale::onDatetime($date_start->toDateTimeString(), $date_end->toDateTimeString())->byStore($store_id)->pending()->get();

    return $sales_pending;
});