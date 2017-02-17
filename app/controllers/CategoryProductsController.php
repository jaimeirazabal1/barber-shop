<?php

class CategoryProductsController extends \BaseController {

    /**
     * Display a listing of categoryproducts
     *
     * @return Response
     */
    public function index($company)
    {
        $company = Company::bySlug($company)->first();
        $categories = CategoryProduct::where('company_id', $company->id)->paginate(20);

        return View::make('category_products.index', compact('categories'));
    }

    /**
     * Show the form for creating a new categoryproduct
     *
     * @return Response
     */
    public function create($company)
    {
        return View::make('category_products.create');
    }

    /**
     * Store a newly created categoryproduct in storage.
     *
     * @return Response
     */
    public function store($company)
    {
        $company = Company::bySlug($company)->first();
        $validator = Validator::make($data = Input::all(), CategoryProduct::$rules);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $slug = new App\Helpers\Slug;
        $data['slug'] = $slug->generate($data['name'], 'category_products');
        $data['company_id'] = $company->id;
        $data['active'] = empty($data['active']) ? false : true;

        CategoryProduct::create($data);

        Flash::success(trans('messages.flash.created'));
        return Redirect::route('category-products.index', $company->slug);
    }



    /**
     * Show the form for editing the specified categoryproduct.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($company, $id)
    {
        $category = CategoryProduct::find($id);

        return View::make('category_products.edit', compact('category'));
    }

    /**
     * Update the specified categoryproduct in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($company, $id)
    {
        $company = Company::bySlug($company)->first();
        $category = CategoryProduct::findOrFail($id);

        $validator = Validator::make($data = Input::all(), CategoryProduct::$rules);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['company_id'] = $company->id;
        $data['active'] = empty($data['active']) ? false : true;

        $category->update($data);

        Flash::success(trans('messages.flash.updated'));
        return Redirect::route('category-products.index', $company->slug);
    }



}