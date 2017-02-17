<?php

use \Barber\Repositories\User\UserRepository as User;


/**
 * Class CustomersController
 */
class CustomersController extends \BaseController {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Display a listing of customers
     *
     * @return Response
     */
    public function index($company)
    {
        $company   = Company::bySlug($company)->first();
        $customers = Customer::byCompany($company->id);

        $filter = Input::get('s', null);

        if ( ! empty($filter))
        {
            $customers = $customers->filter($filter);
        }

        $customers = $customers->paginate(25);

        $customers->appends(['s' => $filter]);


        return View::make('customers.index', compact('customers', 'filter'));
    }

    /**
     * Show the form for creating a new customer
     *
     * @return Response
     */
    public function create($company)
    {
        $company = Company::bySlug($company)->first();
        $barbers = $this->barberOptions();
        $days = $this->days();
        $months = $this->months();
        $years = $this->years();
        $services = $this->services($company->id);

        return View::make('customers.create', compact('barbers', 'days', 'months', 'years', 'services'));
    }

    /**
     * Store a newly created customer in storage.
     *
     * @return Response
     */
    public function store($company)
    {
        $data = Input::all();

        $company            = Company::bySlug($company)->first();
        $data['birthdate']  = ( ! empty($data['birthdate_day']) and ! empty($data['birthdate_month']) and ! empty($data['birthdate_year'])) ? (\Carbon\Carbon::create($data['birthdate_year'], $data['birthdate_month'], $data['birthdate_day'], 0, 0, 0, 'America/Mexico_City')->toDateString()) : null;

        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => '',
            'aka' => '',
            'birthdate' => '',
            'email' => 'email|unique:customers|unique:users',
            'phone' => '',
            'cellphone' => '',
            'notes' => '',
            'barber_id' => '',
            'user_id' => '',
            'company_id' => '',
        ]);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['barber_id'] = empty($data['barber_id']) ? null : $data['barber_id'];


        $data['company_id'] = $company->id;

        if ( ! empty($data['email']))
        {
            $data['send_email_notifications'] = empty($data['send_email_notifications']) ? false : true;
            $data['create_user_account'] = empty($data['create_user_account']) ? false : true;
        }

        if ( ! empty($data['cellphone']))
        {
            $data['send_cellphone_notifications'] = empty($data['send_cellphone_notifications']) ? false : true;
        }

        // TODO : NOTIFICAR AL CLIENTE POR CORREO ELECTRONICO SOBRE SU NUEVA CUENTA
        if ( ! empty($data['create_user_account']))
        {
            $password = Str::random(12); // Contraseña temporal enviada al cliente

            $user = $this->user->create([
                'email' => $data['email'],
                'password' => $password,
                'activated' => false,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name']
            ]);
            $data['user_id'] = $user->id;

            # Crea el usuario para la empresa
            $company->users()->attach($user->id);
        }

        $customer = Customer::create($data);

        if ( ! empty($data['services']))
        {
            $dataServices = array();
            foreach($data['services'] as $serviceKey => $servicePercent)
            {
                $dataServices = array_add($dataServices, $serviceKey, array('estimated_time' => empty($servicePercent) ? 30 : $servicePercent));
            }

            $customer->services()->sync($dataServices);
        }

        Flash::success(trans('messages.flash.created'));
        return Redirect::route('customers.index', $company->slug);
    }



    /**
     * Show the form for editing the specified customer.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($company, $id)
    {
        $company = Company::bySlug($company)->first();
        $days = $this->days();
        $months = $this->months();
        $years = $this->years();
        $customer = Customer::with('services', 'user')->find($id);
        $barbers  = $this->barberOptions();
        $services = $this->services($company->id);

        return View::make('customers.edit', compact('customer', 'barbers', 'days', 'months', 'years', 'services'));
    }

    /**
     * Update the specified customer in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($company, $id)
    {
        $customer = Customer::find($id);
        $company  = Company::bySlug($company)->first();

        $email_rule = '';

        if ( ! empty($customer->email) and empty($customer->user_id)) //Se registro el correo pero la cuenta de usuario no se ha creado
        {
            $email_rule = 'email|unique:customers,email,' . $customer->id;
        }
        else if ( empty($customer->email) and empty($customer->user_id)) // No se ha registrado el correo ni el usuario ha sido creado
        {
            $email_rule = 'email|unique:customers|unique:users';
        }
        else if (! empty($customer->user_id) and ! empty($customer->email)) // La cuenta de usuario ya fue creada y el email ya fue registrado
        {
            $email_rule = '';
        }

        $validator = Validator::make($data = Input::all(), [
            'first_name' => 'required',
            'last_name' => '',
            'aka' => '',
            'birthdate' => '',
            'email' => $email_rule,
            'phone' => '',
            'cellphone' => '',
            'notes' => '',
            'barber_id' => '',
            'user_id' => '',
            'company_id' => '',
        ]);


        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['birthdate']  = ( ! empty($data['birthdate_day']) and ! empty($data['birthdate_month']) and ! empty($data['birthdate_year'])) ? (\Carbon\Carbon::create($data['birthdate_year'], $data['birthdate_month'], $data['birthdate_day'], 0, 0, 0, 'America/Mexico_City')->toDateString()) : null;
        $data['barber_id']  = empty($data['barber_id']) ? null : $data['barber_id'];

        $data['email'] = empty($customer->email) ? $data['email'] : $customer->email;

        if ( ! empty($data['email']))
        {
            $data['send_email_notifications'] = empty($data['send_email_notifications']) ? false : true;
            $data['create_user_account']      = empty($data['create_user_account']) ? false : true;
        }

        if ( ! empty($data['cellphone']))
        {
            $data['send_cellphone_notifications'] = empty($data['send_cellphone_notifications']) ? false : true;
        }


        // TODO : NOTIFICAR AL CLIENTE POR CORREO ELECTRONICO SOBRE SU NUEVA CUENTA
        if ( empty($customer->user_id) and ! empty($data['create_user_account']))
        {
            $password = Str::random(12); // Contraseña temporal enviada al cliente

            $user = $this->user->create([
                'email' => $data['email'],
                'password' => $password,
                'activated' => false,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name']
            ]);
            $data['user_id'] = $user->id;

            # Crea el usuario para la empresa
            $company->users()->attach($user->id);
        }
        else if ( ! empty($customer->user_id)) // Actualiza los datos del usuario
        {
            $user = $this->user->update($customer->user_id, [
                'first_name' => $customer->first_name,
                'last_name'  => $customer->last_name
            ]);
        }



        if ( ! empty($data['services']))
        {
            $dataServices = array();
            foreach($data['services'] as $serviceKey => $servicePercent)
            {
                $dataServices = array_add($dataServices, $serviceKey, array('estimated_time' => empty($servicePercent) ? 0 : $servicePercent));
            }

            $customer->services()->sync($dataServices);
        }


        $customer->update($data);

        Flash::success(trans('messages.flash.updated'));
        return Redirect::route('customers.index', $company->slug);
    }


    /**
     * @return mixed
     */
    private function barberOptions()
    {
        // TODO : Filtrar barberos por company_id
        $barbers = \Barber::whereActive(true)->select('id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'))->orderBy('full_name')->lists('full_name', 'id');
        $barbers[''] = 'Barbero de Preferencia';
        ksort($barbers);

        return $barbers;
    }

    /**
     * @return array
     */
    private function days()
    {
        $days = array();
        for($i = 1; $i <= 31; $i++)
        {
            $days[$i] = $i;
        }
        $days[''] = 'Día';
        ksort($days);
        return $days;
    }

    /**
     * @return array
     */
    private function months()
    {
        $days = array();
        for($i = 1; $i <= 12; $i++)
        {
            $days[$i] = $i;
        }
        $days[''] = 'Mes';
        ksort($days);
        return $days;
    }

    /**
     * @return array
     */
    private function years()
    {
        $days = array();
        for($i = 1920; $i <= date('Y'); $i++)
        {
            $days[$i] = $i;
        }
        $days[''] = 'Año';
        ksort($days);
        return $days;
    }


    private function services($company_id)
    {
        $services = DB::table('services')
            ->where('company_id', $company_id)
            ->select('services.name', 'services.id')
            ->orderby('services.name', 'asc')
            ->get();

        $servicesOptions = array(
            '' => 'Servicios disponibles'
        );

        foreach($services as $service)
        {
            $servicesOptions = array_add($servicesOptions, $service->id, $service->name);
        }

        return $servicesOptions;
    }



}