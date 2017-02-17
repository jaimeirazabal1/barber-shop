<?php

class SuppliersController extends \BaseController {

    /**
     * Display a listing of suppliers
     *
     * @return Response
     */
    public function index($company)
    {
        $company = Company::bySlug($company)->first();
        $suppliers = Supplier::where('company_id', $company->id)->paginate(20);

        return View::make('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new supplier
     *
     * @return Response
     */
    public function create($company)
    {
        return View::make('suppliers.create');
    }

    /**
     * Store a newly created supplier in storage.
     *
     * @return Response
     */
    public function store($company)
    {
        $company = Company::bySlug($company)->first();
        $validator = Validator::make($data = Input::all(), Supplier::$rules);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['company_id'] = $company->id;
        Supplier::create($data);

        Flash::success(trans('messages.flash.created'));
        return Redirect::route('suppliers.index', $company->slug);
    }


    /**
     * Show the form for editing the specified supplier.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($company, $id)
    {
        $supplier = Supplier::find($id);

        return View::make('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($company, $id)
    {
        $company = Company::bySlug($company)->first();
        $supplier = Supplier::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Supplier::$rules);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $data['company_id'] = $company->id;

        $supplier->update($data);

        Flash::success(trans('messages.flash.updated'));
        return Redirect::route('suppliers.index', $company->slug);
    }

}