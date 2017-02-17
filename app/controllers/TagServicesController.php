<?php

class TagServicesController extends \BaseController {

    /**
     * Display a listing of tagservices
     *
     * @return Response
     */
    public function index($company)
    {
        $company = Company::bySlug($company)->first();
        $tags = TagService::where('company_id', $company->id)->paginate(20);

        return View::make('tag_services.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tagservice
     *
     * @return Response
     */
    public function create($company)
    {
        return View::make('tag_services.create', compact('company'));
    }

    /**
     * Store a newly created tagservice in storage.
     *
     * @return Response
     */
    public function store($company)
    {
        $company = Company::bySlug($company)->first();
        $validator = Validator::make($data = Input::all(), TagService::$rules);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['company_id'] = $company->id;
        $slug = new App\Helpers\Slug;
        $data['slug'] = $slug->generate($data['name'], 'tag_products');

        TagService::create($data);

        Flash::success(trans('messages.flash.created'));
        return Redirect::route('tag-services.index', $company->slug);
    }



    /**
     * Show the form for editing the specified tagservice.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($company, $id)
    {
        $tag = TagService::find($id);

        return View::make('tag_services.edit', compact('tag'));
    }

    /**
     * Update the specified tagservice in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($company, $id)
    {
        $company = Company::bySlug($company)->first();
        $tag = TagService::findOrFail($id);

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
        return Redirect::route('tag-services.index', $company->slug);
    }

}