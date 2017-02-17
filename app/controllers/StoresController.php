<?php

use \Carbon\Carbon as Carbon;

// TODO : Refactorizar controlador, consumir API

// TODO : Abrir checador desde la sucursal, listado y edición

/**
 * Class StoresController
 */
class StoresController extends \AppController {

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('stores.list', array('only' => array('index')));
        $this->beforeFilter('stores.create', array('only' => array('create', 'store')));
        $this->beforeFilter('stores.update', array('only' => array('edit', 'update')));

    }

    /**
     * Display a listing of stores
     *
     * @return Response
     */
    public function index($company)
    {
        $company = Company::bySlug($company)->first();
        $stores = Store::with('user')->byCompany($company->id)->paginate(20);

        return View::make('stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new store
     *
     * @return Response
     */
    public function create($company)
    {
        $days = getScheduleDays();
        $company = Company::bySlug($company)->with('users')->first();

        $users = $this->usersOptions($company->users);

        return View::make('stores.create', compact('days', 'users'));
    }

    private function usersOptions($users)
    {
        $options = [];

        $options['0'] = 'Sin administrador';

        foreach($users as $user)
        {
            if ( $user->hasAccess('store'))
            {
                $options[$user->id] = ($user->first_name . ' ' . $user->last_name);
            }
        }

        return $options;
    }

    /**
     * Store a newly created store in storage.
     *
     * @return Response
     */
    public function store($company)
    {
        $validator = Validator::make($data = Input::all(), [
            'name' => 'required',
            'slug' => 'unique:stores,slug',
            'address' => 'required',
            'formatted_address' => 'required',
            'phone' => '',
            'email' => '',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'is_matrix' => '',
            'active' => '',
            'order' => 'integer',
            'tolerance_time' => 'integer|min:0',
            'company_id' => ''
        ]);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $company = Company::bySlug($company)->first();

        $data['company_id'] = $company->id;
        $slug = new App\Helpers\Slug;
        $data['slug'] = $slug->generate($data['name'], 'stores');
        $data['active'] = empty($data['active']) ? false : true;
        $data['is_matrix'] = empty($data['is_matrix']) ? false : true;
        $data['start_appointments'] = Carbon::createFromFormat('g:i A', $data['start_appointments'])->toTimeString();
        $data['end_appointments']   = Carbon::createFromFormat('g:i A', $data['end_appointments'])->toTimeString();
        $data['user_id']            = (empty($data['user_id']) or $data['user_id'] == 0) ? null : $data['user_id'];

        if ( $data['is_matrix'])
        {
            Store::where('company_id', $company->id)->update(array('is_matrix' => false));
        }

        $store = Store::create($data);


        // Horarios de la sucursal
        if ( ! empty($data['schedules']))
        {
            foreach($data['schedules'] as $day => $schedule)
            {

                if ( ! empty($schedule['day']))
                {
                    $opening = Carbon::createFromFormat('g:i A', $schedule['opening'])->toTimeString();
                    $closing = Carbon::createFromFormat('g:i A', $schedule['closing'])->toTimeString();
                    #$opening_appointments = Carbon::createFromFormat('g:i A', $schedule['opening_appointments'])->toTimeString();
                    #$closing_appointments = Carbon::createFromFormat('g:i A', $schedule['closing_appointments'])->toTimeString();
                    $checkin_limit = Carbon::createFromFormat('g:i A', $schedule['checkin_limit'])->toTimeString();

                    $scheduleData = [
                        'day' => $day,
                        'opening' => $opening,
                        'closing' => $closing,
                        #'opening_appointments' => $opening_appointments,
                        #'closing_appointments' => $closing_appointments,
                        'checkin_limit' => $checkin_limit,
                        'store_id' => $store->id
                    ];

                    Schedule::create($scheduleData);
                }

            }
        }

        Flash::success(trans('messages.flash.created'));
        return Redirect::route('stores.index', $company->slug);
    }

    /**
     * Display the specified store.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($company, $id)
    {
        $store = Store::findOrFail($id);

        return View::make('stores.show', compact('store'));
    }

    /**
     * Show the form for editing the specified store.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($company, $id)
    {
        $store = Store::with('schedules')->find($id);

        // COMPRUEBA SI EL USUARIO ES SUCURSAL Y ES LA SUCURSAL QUE LE CORRESPONDE
        if ($this->user->hasAccess('store') and $store->user_id != $this->user->id)
        {
            return Redirect::route('sessions.forbidden', $company);
        }

        $days = getScheduleDays();

        $start_appointments = Carbon::createFromFormat('H:i:s', $store->start_appointments)->format('g:i A');
        $end_appointments   = Carbon::createFromFormat('H:i:s', $store->end_appointments)->format('g:i A');

        $daysSchedule = [];

        foreach($store->schedules as $schedule)
        {
            $daysSchedule[$schedule->day] = [
                'opening' => Carbon::createFromFormat('H:i:s', $schedule->opening)->format('g:i A'),
                'closing' => Carbon::createFromFormat('H:i:s', $schedule->closing)->format('g:i A'),
                #'opening_appointments' => Carbon::createFromFormat('H:i:s', $schedule->opening_appointments)->format('g:i A'),
                #'closing_appointments' => Carbon::createFromFormat('H:i:s', $schedule->closing_appointments)->format('g:i A'),
                'checkin_limit' => Carbon::createFromFormat('H:i:s', $schedule->checkin_limit)->format('g:i A')
            ];
        }

        $company = Company::bySlug($company)->with('users')->first();
        $users   = $this->usersOptions($company->users);

        return View::make('stores.edit', compact('store', 'users', 'days', 'daysSchedule', 'start_appointments', 'end_appointments'));
    }

    /**
     * Update the specified store in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($company, $id)
    {
        $store = Store::findOrFail($id);

        // COMPRUEBA SI EL USUARIO ES SUCURSAL Y ES LA SUCURSAL QUE LE CORRESPONDE
        if ($this->user->hasAccess('store') and $store->user_id != $this->user->id)
        {
            return Redirect::route('sessions.forbidden', $company);
        }

        $validator = Validator::make($data = Input::all(), [
            'name' => 'required',
            'slug' => 'unique:stores,slug,' . $id,
            'address' => 'required',
            'formatted_address' => 'required',
            'phone' => '',
            'email' => '',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'is_matrix' => '',
            'active' => '',
            'order' => 'integer',
            'tolerance_time' => 'integer|min:0',
            'company_id' => '',
            'user_id' => ''
        ]);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $company = Company::bySlug($company)->first();



        $data['company_id'] = $company->id;
        $data['start_appointments'] = Carbon::createFromFormat('g:i A', $data['start_appointments'])->toTimeString();
        $data['end_appointments']   = Carbon::createFromFormat('g:i A', $data['end_appointments'])->toTimeString();

        if ( ! $this->user->hasAccess('store'))
        {
            $data['user_id']   = (empty($data['user_id']) or $data['user_id'] == 0) ? null : $data['user_id'];
            $data['is_matrix'] = empty($data['is_matrix']) ? false : true;
            $data['active']    = empty($data['active']) ? false : true;
            $data['tolerance_time'] = 0;

            if ( $data['is_matrix'])
            {
                Store::where('company_id', $company->id)->update(array('is_matrix' => false));
            }
        }

        $store->update($data);


        // Horarios de la sucursal
        if ( ! empty($data['schedules']))
        {
            foreach($data['schedules'] as $day => $schedule)
            {
                $scheduleModel = Schedule::where('store_id', $store->id)->where('day', $day)->first();

                if ( ! empty($schedule['day']))
                {
                    $opening = Carbon::createFromFormat('g:i A', $schedule['opening'])->toTimeString();
                    $closing = Carbon::createFromFormat('g:i A', $schedule['closing'])->toTimeString();
                    #$opening_appointments = Carbon::createFromFormat('g:i A', $schedule['opening_appointments'])->toTimeString();
                    #$closing_appointments = Carbon::createFromFormat('g:i A', $schedule['closing_appointments'])->toTimeString();
                    $checkin_limit = Carbon::createFromFormat('g:i A', $schedule['checkin_limit'])->toTimeString();

                    $scheduleData = [
                        'day' => $day,
                        'opening' => $opening,
                        'closing' => $closing,
                        #'opening_appointments' => $opening_appointments,
                        #'closing_appointments' => $closing_appointments,
                        'checkin_limit' => $checkin_limit,
                        'store_id' => $store->id
                    ];

                    if ( ! $scheduleModel)
                    {
                        Schedule::create($scheduleData);
                    }
                    else
                    {
                        $scheduleModel->update($scheduleData);
                    }
                }
                else // El horario ya no esta activo y se elimina
                {
                    if ( ! empty($scheduleModel))
                    {
                        $scheduleModel->destroy($scheduleModel->id);
                    }
                }
            }
        }

        Flash::success(trans('messages.flash.updated'));
        return Redirect::route('stores.edit', [$company->slug, $store->id]);
    }


}