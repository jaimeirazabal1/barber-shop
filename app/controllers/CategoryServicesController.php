<?php

class CategoryServicesController extends \BaseController {

    /**
     * Display a listing of categoryservices
     *
     * @return Response
     */
    public function index($company)
    {
        $company = Company::bySlug($company)->first();
        $categories = CategoryService::where('company_id', $company->id)->paginate(20);

        return View::make('category_services.index', compact('categories'));
    }

    /**
     * Show the form for creating a new categoryservice
     *
     * @return Response
     */
    public function create($company)
    {
        return View::make('category_services.create', compact('company'));
    }

    /**
     * Store a newly created categoryservice in storage.
     *
     * @return Response
     */
    public function store($company)
    {
        $company = Company::bySlug($company)->first();
        $validator = Validator::make($data = Input::all(), CategoryService::$rules);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $slug = new App\Helpers\Slug;
        $data['slug'] = $slug->generate($data['name'], 'category_products');
        $data['company_id'] = $company->id;
        $data['active'] = empty($data['active']) ? false : true;

        CategoryService::create($data);

        Flash::success(trans('messages.flash.created'));
        return Redirect::route('category-services.index', $company->slug);
    }


    /**
     * Show the form for editing the specified categoryservice.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($company, $id)
    {
        $category = CategoryService::find($id);

        return View::make('category_services.edit', compact('category', 'company'));
    }

    /**
     * Update the specified categoryservice in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($company, $id)
    {
        $company = Company::bySlug($company)->first();
        $category = CategoryService::findOrFail($id);

        $validator = Validator::make($data = Input::all(), CategoryService::$rules);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['company_id'] = $company->id;
        $data['active'] = empty($data['active']) ? false : true;

        $category->update($data);

        Flash::success(trans('messages.flash.updated'));
        return Redirect::route('category-services.index', $company->slug);
    }


}