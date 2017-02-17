<?php

use Barber\Repositories\Appointment\AppointmentRepository;
use Barber\Repositories\Company\CompanyRepository;
use Barber\Repositories\Store\StoreRepository;
use \Carbon\Carbon as Carbon;

/**
 * Class PayrollController
 */
class PayrollController extends \AppController {


    /**
     * @var AppointmentRepository
     */
    private $appointment;

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
     * @param CompanyRepository $company
     * @param StoreRepository $store
     */
    public function __construct(AppointmentRepository $appointment, CompanyRepository $company, StoreRepository $store)
    {
        parent::__construct();

        /*$this->beforeFilter('sales.list', array('only' => array('index')));
        $this->beforeFilter('sales.create', array('only' => array('create', 'store')));
        $this->beforeFilter('sales.update', array('only' => array('edit', 'update')));
        */

        $this->appointment = $appointment;
        $this->companyrepo = $company;
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

        $commissions = Commission::byCompany($company->id)->get();

        $payroll = Company::with('stores.barbers.checkins')->find($company->id);

        # obtiene la empresa con sucursales, barberos, checkins

        $date_current = Carbon::now();

        // Obtiene los días laborales de la semana actual de Lunes a Sábado
        $dates = getWorkDays($date_current->timestamp);

        $date_start = $dates['start'];
        $date_end   = $dates['end'];

        $barbers = Barber::with(['checkins' => function($query) use ($date_start, $date_end)
        {
            $query->between($date_start->format('Y-m-d'), $date_end->format('Y-m-d'));
        }])->with(['appointments' => function($query) use ($date_start, $date_end)
        {
            $query->between($date_start->format('Y-m-d'), $date_end->format('Y-m-d'))->where('status', 'completed');
        }])->byCompany($company->id)->get();


        $checkin_barbers = [];

        foreach($barbers as $barber)
        {
            foreach($barber->checkins as $checkin)
            {
                $checkin_barbers[$barber->id][$checkin->checkin->format('d')]['checkin'] = $checkin;
            }

            $totalServices = 0;

            if ( count($barber->appointments))
            {
                foreach($barber->appointments as $appointment)
                {
                    foreach($appointment->services as $service)
                    {
                        $totalServices += $service->price;
                    }
                }

            }

            $checkin_barbers[$barber->id]['services'] = $totalServices;
        }

        return View::make('payroll.index', compact('checkin_barbers', 'date_start', 'date_end', 'date_current', 'payroll', 'commissions'));
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
        $data                = Input::all();
        $store_id            = Input::get('store', null);
        $appointment_id      = Input::get('appointment', null);
        $appointment         = empty($appointment_id) ? null : Appointment::find($appointment_id);
        $data['customer_id'] = empty($appointment) ? null : $appointment->customer_id;
        $data['appointment_id'] = empty($appointment) ? null : $appointment->id;
        $data['status']      = empty($data['customer_id']) ? 'paid' : 'pending';
        $total               = 0;

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
            'total' => ''
        ]);


        if ($validator->fails())
        {
            if (Request::ajax())
            {
                return Response::json([
                    'success' => false
                ], 500);
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

        $sale = Sale::find($id);

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

        $company        = $this->companyrepo->getBySlug($company);

        $appointment    = null;

        if( $appointment_id)
        {
            // TODO : agregar try catch aqui y en controlador appointments
            $appointment = $this->appointment->getById($appointment_id);
        }

        $products        = $this->product->getByCompany($company->id);


        return View::make('sales.edit', compact('appointment', 'products', 'store', 'sale'));
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


        // Calcula el total de los productos
        if ( ! empty($data['products']) and count($data['products']))
        {
            $dataProducts = array();

            foreach($data['products'] as $serviceKey => $serviceQuantity)
            {
                $product = Product::find($serviceKey);

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
        $sale->comments = empty($data['comments']) ? null : $data['comments'];
        $sale->checkout = Carbon::now()->toDateTimeString();
        $sale->save();

        Flash::success(trans('messages.flash.updated'));

        return Redirect::route('sales.index', [$company, 'store' => $store]);
    }


}