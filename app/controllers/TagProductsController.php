<?php

class TagProductsController extends \BaseController {

    /**
     * Display a listing of tagproducts
     *
     * @return Response
     */
    public function index($company)
    {
        $company = Company::bySlug($company)->first();
        $tags = TagProduct::where('company_id', $company->id)->paginate(20);

        return View::make('tag_products.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tagproduct
     *
     * @return Response
     */
    public function create($company)
    {
        return View::make('tag_products.create', compact($company));
    }

    /**
     * Store a newly created tagproduct in storage.
     *
     * @return Response
     */
    public function store($company)
    {
        $company = Company::bySlug($company)->first();
        $validator = Validator::make($data = Input::all(), TagProduct::$rules);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['company_id'] = $company->id;
        $slug = new App\Helpers\Slug;
        $data['slug'] = $slug->generate($data['name'], 'tag_products');

        TagProduct::create($data);

        Flash::success(trans('messages.flash.created'));
        return Redirect::route('tag-products.index', $company->slug);
    }


    /**
     * Show the form for editing the specified tagproduct.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($company, $id)
    {
        $tag = TagProduct::find($id);

        return View::make('tag_products.edit', compact('tag'));
    }

    /**
     * Update the specified tagproduct in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($company, $id)
    {
        $company = Company::bySlug($company)->first();
        $tag = TagProduct::findOrFail($id);

        $validator = Validator::make($data = Input::all(), [
            'name' => 'required',
            'slug' => '',
            'company_id' => 'integer'
        ]);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['company_id'] = $company->id;
        $tag->update($data);

        Flash::success(trans('messages.flash.updated'));
        return Redirect::route('tag-products.index', $company->slug);
    }


}