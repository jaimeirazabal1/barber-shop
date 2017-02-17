<?php

use \Carbon\Carbon as Carbon;

// TODO : actualizar codigo

/**
 * Class BarbersController
 */
class BarbersController extends \BaseController {

    /**
     * Display a listing of barbers
     *
     * @return Response
     */
    public function index($company)
    {
        $company = Company::bySlug($company)->first();
        $barbers = Barber::byCompany($company->id)->paginate(20);

        return View::make('barbers.index', compact('barbers'));
    }

    /**
     * Show the form for creating a new barber
     *
     * @return Response
     */
    public function create($company)
    {
        $company = Company::bySlug($company)->first();
        $salaries = $this->salaryTypes();
        $stores   = $this->stores($company->id);

        return View::make('barbers.create', compact('salaries', 'stores'));
    }

    /**
     * Store a newly created barber in storage.
     *
     * @return Response
     */
    public function store($company)
    {
        $data = Input::all();

        $company            = Company::bySlug($company)->first();
        $data['company_id'] = $company->id;

        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => '',
            'address' => '',
            'phone' => '',
            'cellphone' => '',
            'email' => 'email',
            'color' => 'required',
            'code' => 'required|unique:barbers',
            'salary_type' => '',
            'salary' => 'required|money',
            'active' => '',
            'store_id' => 'required',
            'company_id' => 'required',
            'mealtime_in' => 'required',
            'mealtime_out' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
        ]);

        // TODO : actualizar validaciones de Barbero


        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['salary_type'] = 'weekly';
        $data['salary']   = convertMoneyToInteger($data['salary']);
        $data['active']   = empty($data['active']) ? false : true;
        $data['mealtime_in']  = Carbon::createFromFormat('H:i A', $data['mealtime_in'])->toTimeString();
        $data['mealtime_out']  = Carbon::createFromFormat('H:i A', $data['mealtime_out'])->toTimeString();
        $data['check_in']  = Carbon::createFromFormat('H:i A', $data['check_in'])->toTimeString();
        $data['check_out']  = Carbon::createFromFormat('H:i A', $data['check_out'])->toTimeString();

        $barber = Barber::create($data);

        Flash::success(trans('messages.flash.created'));
        return Redirect::route('barbers.index', $company->slug);
    }


    /**
     * Show the form for editing the specified barber.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($company, $id)
    {
        $company  = Company::bySlug($company)->first();
        $salaries = $this->salaryTypes();
        $barber   = Barber::find($id);
        $stores   = $this->stores($company->id);
        $mealtime_in   = (empty($barber->mealtime_in)) ? Carbon::now()->format('H:i:s A') : Carbon::createFromFormat('H:i:s', $barber->mealtime_in)->format('g:i A');
        $mealtime_out  = (empty($barber->mealtime_out)) ? Carbon::now()->format('H:i:s A') : Carbon::createFromFormat('H:i:s', $barber->mealtime_out)->format('g:i A');
        $check_in   = (empty($barber->check_in)) ? Carbon::now()->format('H:i:s A') : Carbon::createFromFormat('H:i:s', $barber->check_in)->format('g:i A');
        $check_out  = (empty($barber->check_out)) ? Carbon::now()->format('H:i:s A') : Carbon::createFromFormat('H:i:s', $barber->check_out)->format('g:i A');

        return View::make('barbers.edit', compact('barber', 'salaries', 'stores', 'mealtime_in', 'mealtime_out', 'check_in', 'check_out'));
    }

    /**
     * Update the specified barber in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($company, $id)
    {
        $barber = Barber::find($id);

        $data = Input::all();

        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => '',
            'address' => '',
            'phone' => '',
            'cellphone' => '',
            'email' => 'email|unique:barbers,email,' . $barber->id,
            'color' => 'required',
            'code' => 'required|unique:barbers,code,' . $barber->id,
            'salary_type' => '',
            'salary' => 'required|money',
            'active' => '',
            'store_id' => 'required',
            'mealtime_in' => 'required',
            'mealtime_out' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
        ]);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['salary_type'] = 'weekly';
        $data['salary']   = convertMoneyToInteger($data['salary']);
        $data['active']   = empty($data['active']) ? false : true;
        $data['mealtime_in']  = Carbon::createFromFormat('g:i A', $data['mealtime_in'])->toTimeString();
        $data['mealtime_out']  = Carbon::createFromFormat('g:i A', $data['mealtime_out'])->toTimeString();
        $data['check_in']  = Carbon::createFromFormat('g:i A', $data['check_in'])->toTimeString();
        $data['check_out']  = Carbon::createFromFormat('g:i A', $data['check_out'])->toTimeString();

        $barber->update($data);

        Flash::success(trans('messages.flash.updated'));
        return Redirect::route('barbers.index', $company);
    }




    /**
     * @return array
     */
    private function salaryTypes()
    {
        $types = array(
            '' => 'Tipo de Salario',
            'daily' => 'Diario',
            'weekly' => 'Semanal',
            'biweekly' => 'Quincenal',
            'monthly' => 'Mensual'
        );
        return $types;
    }

    public function stores($company_id)
    {
        $stores = Store::ByCompany($company_id)->lists('name', 'id');
        $stores[''] = 'Selecciona una sucursal';
        ksort($stores);

        return $stores;
    }



}