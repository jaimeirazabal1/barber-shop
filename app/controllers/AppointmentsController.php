<?php
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/15/15
 * Time: 7:16 PM
 */


use Barber\Repositories\Appointment\AppointmentRepository;
use Barber\Repositories\Barber\BarberRepository;
use Barber\Repositories\Company\CompanyRepository;
use Barber\Repositories\Service\ServiceRepository;
use Barber\Repositories\Store\StoreRepository;
use Carbon\Carbon as Carbon;


/**
 * Class AppointmentsController
 */
class AppointmentsController extends AppController {


    /**
     * @var StoreRepository
     */
    protected $store;

    /**
     * @var CompanyRepository
     */
    protected $company;

    /**
     * @var BarberRepository
     */
    protected $barber;

    /**
     * @var
     */
    protected $service;

    /**
     * @var AppointmentRepository
     */
    protected $appointment;

    /**
     * @param StoreRepository $store
     * @param CompanyRepository $company
     * @param BarberRepository $barber
     * @param ServiceRepository $service
     * @param AppointmentRepository $appointment
     */
    public function __construct(StoreRepository $store, CompanyRepository $company, BarberRepository $barber, ServiceRepository $service, AppointmentRepository $appointment)
    {
        parent::__construct();

        $this->beforeFilter('appointments.all', array('only' => array('index', 'edit')));

        $this->store       = $store;
        $this->company     = $company;
        $this->barber      = $barber;
        $this->service     = $service;
        $this->appointment = $appointment;
    }

    /**
     * Listado de Citas
     */
    public function index($company)
    {
        
        $store_id = Input::get('store', null);

        // TODO : validar que la sucursal pertezca a la empresa

        # Empresa
        $company = $this->company->getBySlug($company);

        # Sucursales
        $stores = $this->store->getAll($company->id);


        # Sucursal solicitada
        if ( ! empty($store_id) )
        {
            $store = $this->store->getById($store_id);

            // COMPRUEBA SI EL USUARIO ES SUCURSAL Y ES LA SUCURSAL QUE LE CORRESPONDE
            if ($this->user->hasAccess('store') and $store->user_id != $this->user->id)
            {
                return Redirect::route('sessions.forbidden', $company->slug);
            }
        }
        else
        {
            $store = $this->store->getFirst($company->id);
        }

        # Barberos por sucursal
        $barbers = $this->barber->getByStore($store->id);

        # Servicios por sucursal
        $services = $this->service->getByCompany($company->id);

        $products = \Product::byCompany($company->id)->with(['stores' => function($query) use($store_id)
        {
            $query->where('product_store.store_id', $store_id);
        }])->active()->ordered()->get();

        $company_id = $company->id;

        $store_start_appointments = Carbon::createFromFormat('H:i:s', $store->start_appointments);
        $store_end_appointments   = Carbon::createFromFormat('H:i:s', $store->end_appointments);

        return View::make('appointments.index', compact('stores', 'barbers', 'store', 'services', 'company_id', 'store_start_appointments', 'store_end_appointments', 'products'));
    }

    /**
     *
     */
    public function create($company)
    {
        $input = Input::all();

        $store_id      = $input['store'];
        $date_selected = $input['date'];

        $store = $this->store->getById($store_id);

        $date_today     = \Carbon\Carbon::createFromFormat('Y-m-d', $date_selected);
        $date_yesterday = \Carbon\Carbon::createFromFormat('Y-m-d', $date_selected)->subDay();
        $date_tomorrow  = \Carbon\Carbon::createFromFormat('Y-m-d', $date_selected)->addDay();
        $date_yesterday_format = $date_yesterday->toDateString();
        $date_tomorrow_format  = $date_tomorrow->toDateString();
        $date_today_format     = $date_today->toDateString();

        $start_appointments = \Carbon\Carbon::createFromFormat('H:i:s', $store->start_appointments);
        $end_appointments   = \Carbon\Carbon::createFromFormat('H:i:s', $store->end_appointments);


        $barbers_with_appointments = \Barber::with(['appointments' => function($query) use ($date_yesterday_format, $date_tomorrow_format)
        {
            $query->whereRaw("DATE(start) between ? and ?", array($date_yesterday_format, $date_tomorrow_format))->available();
        }])->byStore($store_id)->ordered()->active()->get();

        $data = [];

        while($date_yesterday->timestamp <= $date_tomorrow->timestamp)
        {
            $year       = $date_yesterday->format('Y');
            $month      = $date_yesterday->format('n');
            $month_name = getMonth($month);
            $day        = $date_yesterday->day;

            $data[$day]['info'] = "{$day}/{$month_name}/{$year}";

            foreach($barbers_with_appointments as $barber)
            {
                $data[$day]['barbers'][$barber->id]['info'] = [
                    'name' => ($barber->first_name . ' ' . $barber->last_name),
                    'color' => $barber->color,
                    'mealtime_in' => $barber->mealtime_in,
                    'mealtime_out' => $barber->mealtime_out,
                    'check_in' => $barber->check_in,
                    'check_out' => $barber->check_out
                ];

                $check_in     = \Carbon\Carbon::createFromFormat('H:i:s', $barber->check_in);
                $mealtime_in  = \Carbon\Carbon::createFromFormat('H:i:s', $barber->mealtime_in);
                $mealtime_out = \Carbon\Carbon::createFromFormat('H:i:s', $barber->mealtime_out);
                $check_out    = \Carbon\Carbon::createFromFormat('H:i:s', $barber->check_out);

                # Agrega los horarios de comida a citas no disponibles
                while($mealtime_in->timestamp < $mealtime_out->timestamp)
                {
                    $data[$day]['barbers'][$barber->id]['booked'][] = $mealtime_in->format('H:i');

                    $mealtime_in->addMinutes(30);
                }

                # Agrupa las citas por dia - barbero
                foreach($barber->appointments as $appointment)
                {
                    $start = $appointment->start;
                    $end   = $appointment->end;

                    if ( empty($data[$start->day]['barbers'][$appointment->barber_id]['appointments'][$appointment->id]))
                    {
                        $data[$start->day]['barbers'][$appointment->barber_id]['appointments'][$appointment->id] = $appointment;

                        $appointment_start = $appointment->start;
                        $appointment_end   = $appointment->end;

                        while($appointment_start->timestamp < $appointment_end->timestamp)
                        {
                            $data[$start->day]['barbers'][$appointment->barber_id]['booked'][] = $appointment_start->format('H:i');

                            $appointment_start->addMinutes(30);
                        }
                    }
                }

                # Horario del barbero

                $check_in_barber  = \Carbon\Carbon::createFromFormat('H:i:s', $barber->check_in);
                $check_out_barber = \Carbon\Carbon::createFromFormat('H:i:s', $barber->check_out);

                while($check_in_barber->timestamp <= $check_out_barber->timestamp)
                {
                    $data[$day]['barbers'][$barber->id]['schedule'][] = $check_in_barber->format('H:i');

                    $check_in_barber->addMinutes(30);
                }

                # Agrega los horarios de citas no disponibles (ya estan ocupadas)
                if ( ! empty($data[$day]['barbers'][$barber->id]['appointments']))
                {
                    while($check_in->timestamp <= $check_out->timestamp)
                    {
                        $data[$day]['barbers'][$barber->id]['agenda'][$check_in->format('H:i')] = [
                            'time' => $check_in->format('H:i'),
                            'available' => (in_array($check_in->format('H:i'), $data[$day]['barbers'][$barber->id]['booked'])) ? false : true
                        ];

                        $check_in->addMinutes(30);
                    }
                }

            }
            $date_yesterday->addDay();
        }

        return View::make('appointments.modals.available', compact('data', 'date_today_format', 'date_yesterday_format', 'date_tomorrow_format', 'store'));
    }

    /**
     *
     */
    public function store()
    {

    }

    /**
     * @param $id
     */
    public function show($id)
    {

    }

    /**
     * @param $id
     */
    public function edit($company, $id)
    {
        $store_id = Input::get('store', null);

        // TODO : validar que la sucursal pertezca a la empresa

        # Empresa
        $company = $this->company->getBySlug($company);

        # Sucursal solicitada
        if ( ! empty($store_id) )
        {
            $store = $this->store->getById($store_id);

            // COMPRUEBA SI EL USUARIO ES SUCURSAL Y ES LA SUCURSAL QUE LE CORRESPONDE
            if ($this->user->hasAccess('store') and $store->user_id != $this->user->id)
            {
                return Redirect::route('sessions.forbidden', $company->slug);
            }
        }
        else
        {
            $store = $this->store->getFirst($company->id);
        }

        # Servicios por sucursal
        $services = $this->service->getByCompany($company->id);

        $appointment = $this->appointment->getById($id);

        $appointment_start = $appointment->start->format('g:i A');
        $appointment_end   = $appointment->end->format('g:i A');

        #return $appointment_start;
        #return $appointment_end;

        $services_selected = array();

        foreach($appointment->services as $service)
        {
            $services_selected[] = $service->id;
        }

        return View::make('appointments.modals.edit', compact('store', 'appointment', 'services', 'appointment_start', 'appointment_end', 'services_selected'));
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {

    }
}