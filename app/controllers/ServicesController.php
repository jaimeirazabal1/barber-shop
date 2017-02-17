<?php

class ServicesController extends \BaseController {

    /**
     * Display a listing of services
     *
     * @return Response
     */
    public function index($company)
    {
        $company = Company::bySlug($company)->first();
        $services = Service::where('company_id', $company->id)->paginate(20);

        return View::make('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service
     *
     * @return Response
     */
    public function create($company)
    {
        $company = Company::bySlug($company)->first();
        $categories = $this->categoryOptions($company->id);
        $tags      = $this->tags($company->id);

        return View::make('services.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created service in storage.
     *
     * @return Response
     */
    public function store($company)
    {
        $company = Company::bySlug($company)->first();
        $validator = Validator::make($data = Input::all(), [
            'name' => 'required',
            'code' => '',
            'price' => 'required|money',
            'image' => 'image',
            'active' => '',
            'order' => 'integer',
            'estimated_time' => 'required|integer', # Minutes
            'company_id' => '',
            'category_id' => 'integer'
        ]);


        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['active'] = empty($data['active']) ? false : true;
        $data['price']  = convertMoneyToInteger($data['price']);
        $data['company_id'] = $company->id;
        $data['category_id'] = empty($data['category_id']) ? null : $data['category_id'];

        $service = Service::create($data);


        if ( ! empty($data['tags']))
        {
            $service->tags()->sync($data['tags']);
        }

        Flash::success(trans('messages.flash.created'));
        return Redirect::route('services.index', $company->slug);
    }


    /**
     * Show the form for editing the specified service.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($company, $id)
    {
        $company = Company::bySlug($company)->first();
        $service = Service::with('tags')->find($id);
        $categories = $this->categoryOptions($company->id);
        $tags      = $this->tags($company->id);

        $tagsSelected = empty($service->tags) ? null : $service->tags->lists('id');



        return View::make('services.edit', compact('service', 'categories', 'tags', 'tagsSelected'));
    }

    /**
     * Update the specified service in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($company, $id)
    {
        $company = Company::bySlug($company)->first();
        $service = Service::findOrFail($id);


        $validator = Validator::make($data = Input::all(), [
            'name' => 'required',
            'code' => '',
            'price' => 'required|money',
            'image' => 'image',
            'active' => '',
            'order' => 'integer',
            'estimated_time' => 'required|integer', # Minutes
            'company_id' => '',
            'category_id' => 'integer'
        ]);

        if ($validator->fails())
        {
            Flash::error(trans('messages.flash.error'));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['active'] = empty($data['active']) ? false : true;
        $data['price']  = convertMoneyToInteger($data['price']);
        $data['company_id'] = $company->id;
        $data['category_id'] = empty($data['category_id']) ? null : $data['category_id'];

        $data['tags'] = empty($data['tags']) ? array() : $data['tags'];

        //return $data;

        $service->tags()->sync($data['tags']);


        $service->update($data);

        Flash::success(trans('messages.flash.updated'));
        return Redirect::route('services.index', $company->slug);
    }



    private function categoryOptions($company_id)
    {
        $categories = CategoryService::where('company_id', $company_id)->lists('name', 'id');
        $categories[''] = 'Categoría de Servicio';
        ksort($categories);

        return $categories;
    }

    private function tags($company_id)
    {
        $tags = TagService::where('company_id', $company_id)->orderBy('name', 'asc')->lists('name', 'id');

        return $tags;
    }

}