<?php
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/19/15
 * Time: 12:27 AM
 */

use Barber\Repositories\Appointment\AppointmentRepository;
use Barber\Repositories\Company\CompanyRepository;

use Barber\Repositories\Product\ProductRepository;
use Barber\Repositories\Store\StoreRepository;
use Barber\Repositories\Service\ServiceRepository;
use \Carbon\Carbon as Carbon;


class SalesController extends AppController {

    /**
     * @var AppointmentRepository
     */
    private $appointment;

    /**
     * @var ProductRepository
     */
    private $product;

    /**
     * @var CompanyRepository
     */
    private $companyrepo;

    /**
     * @var StoreRepository
     */
    private $store;

    /**
     * @param AppointmentRepository $appointment
     * @param ProductRepository $product
     * @param CompanyRepository $company
     * @param StoreRepository $store
     */
    public function __construct(AppointmentRepository $appointment, ProductRepository $product, CompanyRepository $company, StoreRepository $store,ServiceRepository $service)
    {
        parent::__construct();

        $this->beforeFilter('sales.list', array('only' => array('index')));
        $this->beforeFilter('sales.create', array('only' => array('create', 'store')));
        $this->beforeFilter('sales.update', array('only' => array('edit', 'update')));


        $this->appointment = $appointment;
        $this->product     = $product;
        $this->companyrepo = $company;
        $this->company     = $company;
        $this->service     = $service;
        $this->store       = $store;
    }

    /**
     *
     */
    public function index($company)
    {
        $store_id = Input::get('store', null);
        // TODO : validar que la sucursal pertezca a la empresa

        $company = $this->companyrepo->getBySlug($company);

        $store = null;

        # Sucursal solicitada con sus ventas
        if ( ! empty($store_id) )
        {
            $store = $this->store->getById($store_id);

            // COMPRUEBA SI EL USUARIO ES SUCURSAL Y ES LA SUCURSAL QUE LE CORRESPONDE
            if ($this->user->hasAccess('store') and $store->user_id != $this->user->id)
            {
                return Redirect::route('sessions.forbidden', $company->slug);
            }

            $sales = Sale::with('products')->byStore($store_id)->latest()->paginate(20);
        }
        else
        {
            // Si no se especifica la sucursal entonces obtiene las ventas de todos las sucursales
            $sales = Sale::with('products')->latest()->paginate(20);
        }

        $stores  = $this->store->getAll($company->id);

        return View::make('sales.index', compact('sales', 'stores', 'store'));
    }

    /**
     *
     */
    public function create($company)
    {
        $store_id = Input::get('store', null);

        if ( empty($store_id))
        {
            return Redirect::route('sales.index', $company);
        }

        $store = $this->store->getById($store_id);

        // COMPRUEBA SI EL USUARIO ES SUCURSAL Y ES LA SUCURSAL QUE LE CORRESPONDE
        if ($this->user->hasAccess('store') and $store->user_id != $this->user->id)
        {
            return Redirect::route('sessions.forbidden', $company);
        }


        // TODO : verificar si la cita ya fue pagada, entonces redirecciona a ver el detalle de la venta

        // TODO : validar que la sucursal pertezca a la empresa
        $appointment_id = Input::get('appointment', null);

        $company        = $this->companyrepo->getBySlug($company);

        $appointment    = null;

        if( $appointment_id)
        {
            // TODO : agregar try catch aqui y en controlador appointments
            $appointment = $this->appointment->getById($appointment_id);
        }

        $products        = $this->product->getByCompany($company->id);


        return View::make('sales.create', compact('appointment', 'products', 'store'));

    }


    // TODO : validar que la sucursal pertezca a la empresa
    // TODO : venta de mostrador, puede o no incluir un cliente, venta para una cita: ya trae los datos del cliente.
    // TODO : Agregar transacciones de base de datos
    /**
     *
     */
    public function store($company)
    {
        $data                   = Input::all();
        $store_id               = Input::get('store', null);
        $appointment_id         = Input::get('appointment', null);
        $appointment            = empty($appointment_id) ? null : Appointment::find($appointment_id);
        $data['customer_id']    = empty($appointment) ? null : $appointment->customer_id;
        $data['appointment_id'] = empty($appointment) ? null : $appointment->id;
        $data['status']         = empty($data['customer_id']) ? 'paid' : 'pending';
        $total                  = 0;

        if ( ! empty($store_id))
        {
            $storeData = $this->store->getById($store_id);

            // COMPRUEBA SI EL USUARIO ES SUCURSAL Y ES LA SUCURSAL QUE LE CORRESPONDE
            if ($this->user->hasAccess('store') and $storeData->user_id != $this->user->id)
            {
                return Redirect::route('sessions.forbidden', $company);
            }
        }

        $validator = \Validator::make($data, [
            'checkin' => '',
            'comments' => '',
            'status' => '',
            'appointment_id' => 'integer',
            'customer_id' => 'integer',
            'store_id' => 'required|integer',
            'total' => '',
            'type' => 'required',
            'tip' => 'money'
        ]);


        if ($validator->fails())
        {
            if (Request::ajax())
            {
                return Response::json([
                    'success' => false,
                    'error'   => [
                        'message' => $validator->errors()
                    ]
                ], 400);
            }
            else
            {
                Flash::error(trans('messages.flash.error'));
                return Redirect::back()->withErrors($validator)->withInput();
            }
        }


        // La venta se genera desde una cita
        if ( ! empty($appointment) )
        {
            $data['checkin'] = Carbon::now()->toDateTimeString();
        }

        $data['tip'] = empty($data['tip']) ? null : convertMoneyToInteger($data['tip']);


        ////////////// VERIFICA LA EXISTENCIA DE PRODUCTOS ANTES DE CONTINUAR CON LA VENTA //////////////

        // Calcula el total de los productos
        if ( ! empty($data['products']) and count($data['products']))
        {

            foreach($data['products'] as $serviceKey => $serviceQuantity)
            {
                # Encuentra el producto y su existencia
                $producto_stock = \Product::with(['stores' => function($query) use($store_id)
                {
                    $query->where('product_store.store_id', '=', $store_id);
                }])->find($serviceKey);

                # Se terminaron las existencias del producto
                if ( empty($producto_stock->stores[0]->pivot->stock))
                {
                    Flash::success('Las existencias para el producto ' . $producto_stock->name . ' se han agotado.');
                    return Redirect::route('sales.index', [$company, 'store' => $store_id]);
                }
                else
                {
                    # No Son suficientes existencias para la venta
                    if ( $producto_stock->stores[0]->pivot->stock < $serviceQuantity)
                    {
                        Flash::warning('Las existencias para el producto ' . $producto_stock->name . ' no son suficientes, solo hay disponibles ' . $producto_stock->stores[0]->pivot->stock .'.');
                        return Redirect::route('sales.index', [$company, 'store' => $store_id]);
                    }
                }
            }
        }

        /////////////////////////////////////////////////////////////////////////////


        //////////////////////

        $sale = Sale::create($data);

        if ( ! empty($appointment) )
        {
            $appointment->status = 'process';
            $appointment->save();

            // Calcula el total de los servicios
            foreach($appointment->services as $service)
            {
                $total += $service->price;
            }
        }

        // Calcula el total de los productos
        if ( ! empty($data['products']) and count($data['products']))
        {
            $dataProducts = array();

            foreach($data['products'] as $serviceKey => $serviceQuantity)
            {
                $product = Product::find($serviceKey);

                # Encuentra el producto y su existencia
                $producto_stock = \Product::with(['stores' => function($query) use($store_id)
                {
                    $query->where('product_store.store_id', '=', $store_id);
                }])->find($serviceKey);

                $new_stock = ($producto_stock->stores[0]->pivot->stock - $serviceQuantity);

                # Actualiza el stock de existencias
                $product->stores()->updateExistingPivot($store_id, ['stock' => $new_stock]);

                $dataProducts = array_add($dataProducts, $serviceKey, array(
                    'quantity' => (empty($serviceQuantity) ? 0 : $serviceQuantity),
                    'price'    => $product->price
                ));

                $total += ($product->price * $serviceQuantity);
            }

            $sale->products()->sync($dataProducts);
        }

        // Actualiza el total de la venta
        $sale->total = $total;
        $sale->save();

        if (Request::ajax())
        {
            return Response::json([
                'success' => true,
                'data' => $data,
                'sale' => $sale
            ], 200);
        }
        else
        {
            Flash::success(trans('messages.flash.created'));
            return Redirect::route('sales.index', [$company, 'store' => $store_id]);
        }


    }

    public function edit($company, $id)
    {
        $store_id = Input::get('store', null);
        $sale     = Sale::find($id);

        $company = $this->company->getBySlug($company);

        if ( empty($store_id))
        {
            return Redirect::route('sales.index', $company);
        }

        $store = $this->store->getById($store_id);

        // COMPRUEBA SI EL USUARIO ES SUCURSAL Y ES LA SUCURSAL QUE LE CORRESPONDE
        if ($this->user->hasAccess('store') and $store->user_id != $this->user->id)
        {
            return Redirect::route('sessions.forbidden', $company);
        }


        // TODO : verificar si la cita ya fue pagada, entonces redirecciona a ver el detalle de la venta

        // TODO : validar que la sucursal pertezca a la empresa
        $appointment_id = $sale->appointment_id;

        $company        = $this->company->getBySlug($company->slug);
        // var_dump($company);die;
        $appointment    = null;

        if( $appointment_id)
        {
            // TODO : agregar try catch aqui y en controlador appointments
            $appointment = $this->appointment->getById($appointment_id);
        }

        $products        = $this->product->getByCompany($company->id);

        $services = array();
        $services = $this->service->getByCompany($company->id);
        return View::make('sales.edit', compact('appointment', 'products', 'store', 'sale', 'services'));
    }
    public function add_service($appointment_id_,$service_id,$time){
        DB::table('appointment_service')->insert(['estimated_time'=>Input::get('time'),"appointment_id"=>Input::get('appointment_id'),"service_id"=>Input::get('service_id'),"price"=>0]);
        return json_encode(array("success"=>true,'estimated_time'=>Input::get('time'),"appointment_id"=>Input::get('appointment_id'),"service_id"=>Input::get('service_id'),"price"=>0));
    }
    /**
     * @param $id
     */
    public function update($company, $id)
    {
        $data  = Input::all();
        $store = Input::get('store');
        $total = 0;

        $sale = Sale::find($id);

        if ( ! empty($store))
        {
            $storeData = $this->store->getById($store);

            // COMPRUEBA SI EL USUARIO ES SUCURSAL Y ES LA SUCURSAL QUE LE CORRESPONDE
            if ($this->user->hasAccess('store') and $storeData->user_id != $this->user->id)
            {
                return Redirect::route('sessions.forbidden', $company);
            }
        }



        ////////////// VERIFICA LA EXISTENCIA DE PRODUCTOS ANTES DE CONTINUAR CON LA VENTA //////////////

        // Calcula el total de los productos
        if ( ! empty($data['products']) and count($data['products']))
        {

            foreach($data['products'] as $serviceKey => $serviceQuantity)
            {
                # Encuentra el producto y su existencia
                $producto_stock = \Product::with(['stores' => function($query) use($store)
                {
                    $query->where('product_store.store_id', '=', $store);
                }])->find($serviceKey);

                # Se terminaron las existencias del producto
                if ( empty($producto_stock->stores[0]->pivot->stock))
                {
                    Flash::success('Las existencias para el producto ' . $producto_stock->name . ' se han agotado.');
                    return Redirect::route('sales.index', [$company, 'store' => $store]);
                }
                else
                {
                    # No Son suficientes existencias para la venta
                    if ( $producto_stock->stores[0]->pivot->stock < $serviceQuantity)
                    {
                        Flash::warning('Las existencias para el producto ' . $producto_stock->name . ' no son suficientes, solo hay disponibles ' . $producto_stock->stores[0]->pivot->stock .'.');
                        return Redirect::route('sales.index', [$company, 'store' => $store]);
                    }
                }
            }
        }

        /////////////////////////////////////////////////////////////////////////////



        // Calcula el total de los productos
        if ( ! empty($data['products']) and count($data['products']))
        {
            $dataProducts = array();

            foreach($data['products'] as $serviceKey => $serviceQuantity)
            {
                $product = Product::find($serviceKey);

                # Encuentra el producto y su existencia
                $producto_stock = \Product::with(['stores' => function($query) use($store)
                {
                    $query->where('product_store.store_id', '=', $store);
                }])->find($serviceKey);

                $new_stock = ($producto_stock->stores[0]->pivot->stock - $serviceQuantity);

                # Actualiza el stock de existencias
                $product->stores()->updateExistingPivot($store, ['stock' => $new_stock]);

                $dataProducts = array_add($dataProducts, $serviceKey, array(
                    'quantity' => (empty($serviceQuantity) ? 0 : $serviceQuantity),
                    'price'    => $product->price
                ));

                $total += ($product->price * $serviceQuantity);
            }

            $sale->products()->sync($dataProducts);
        }

        $appointment = Appointment::find($sale->appointment_id);
        $appointment->status = 'completed';
        $appointment->save();

        // Calcula el total de los servicios
        if ( ! empty($appointment) )
        {
            foreach($appointment->services as $service)
            {
                $total += $service->price;
            }
        }

        // Actualiza el total de la venta
        $sale->total  = $total;
        $sale->status = 'paid';
        $sale->type   = empty($data['type']) ? $sale->type : $data['type'];

        if ($sale->type == 'cash')
        {
            $sale->tip = null;
        }
        else
        {
            $sale->tip = empty($data['tip']) ? $sale->tip : convertMoneyToInteger($data['tip']);
        }

        $sale->comments = empty($data['comments']) ? null : $data['comments'];
        $sale->checkout = Carbon::now()->toDateTimeString();
        $sale->save();

        Flash::success(trans('messages.flash.updated'));

        return Redirect::route('sales.index', [$company, 'store' => $store]);
    }

}