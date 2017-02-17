<?php
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/26/15
 * Time: 4:38 PM
 */



/**
 * Class UsersController
 * @package Admin
 */
class UsersController extends AppController {


    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of users
     *
     * @return Response
     */
    public function index($company)
    {
        $company = Company::bySlug($company)->with('users.store')->first();
        $users = $company->users;
        $users_new = array();
        foreach ($users as $key => $value) {
            $registro = DB::table('store_user')->where('user_id',$value->id)->get();
            if ($registro) {
                $store_name = DB::table('stores')->where('id',$registro[0]->store_id)->get();
                $value->store_id = $registro[0]->store_id;
                $value->store_name = $store_name[0]->name;
            }else{
                $value->store_name = ' - ';
            }
        };
        return View::make('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function create($company)
    {
        $profiles     = $this->profileOptions();
        $profile_user = null;
        $stores       = Store::lists('name', 'id');

        return View::make('users.create', compact('profiles', 'profile_user', 'stores'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store($company)
    {
        $company = Company::bySlug($company)->first();

        $validator = Validator::make($data = Input::all(), [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
            'group_id'              => 'required|integer',
            'store_id'              => 'required'
        ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['activated'] = empty($data['activated']) ? false : true;

        $user = Sentry::createUser(array(
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => $data['password'],
            'activated'  => $data['activated'],
        ));

        // Find the group using the group id
        if ($this->user->hasAccess('company'))
        {
            $group_type = 'Sucursal';

            switch($data['group_id'])
            {
                case 1:
                    $group_type = 'Empresa';
                    break;
                case 2:
                    $group_type = 'Sucursal';
                    break;
                default:
                    $group_type = 'Sucursal';
                    break;
            }

            $group = Sentry::findGroupByName($group_type);

            // Assign the group to the user
            $user->addGroup($group);

            # Asigna al nuevo usuario a la empresa
            $company->users()->attach($user->id);

            if ($data['group_id'] == 2) // Si el usuario es sucursal entonces se le asigna
            {
                $store = Store::find($data['store_id']);
                $store->user_id = $user->id;
                $store->save();
            }

        }
        else if ($this->user->hasAccess('admin'))
        {
            $group = Sentry::findGroupById($data['group_id']);

            // Assign the group to the user
            $user->addGroup($group);

            # Asigna al nuevo usuario a la empresa
            $company->users()->attach($user->id);
        }

        Flash::success(trans('messages.flash.created'));

        return Redirect::route('users.index', $company->slug);
    }



    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($company, $id)
    {
        $user         = User::find($id);
        $profiles     = $this->profileOptions();
        $profile_user = $user->getGroups()->first();
        $profile_user = empty($profile_user->id) ? null : $profile_user->id;
        $stores       = Store::lists('name', 'id');

        return View::make('users.edit', compact('user', 'profiles', 'profile_user', 'stores'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($company, $id)
    {
//    	return $_POST;
        $user = Sentry::findUserById($id);

        $validator = Validator::make($data = Input::all(), [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'email'                 => 'required|email|unique:users,email,' . $user->id,
            'password'              => 'confirmed|min:8',
            'password_confirmation' => 'min:8',
            'group_id'              => 'required|integer',
            'store_id'              => 'required'
        ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['activated'] = empty($data['activated']) ? false : true;

        /*if ($this->user->hasAccess('admin')) // Solo el administrador puede cambiar los roles de los usuarios
        {
            $group = Sentry::findGroupById($data['group_id']);

            // Assign the group to the user
            $user->addGroup($group);

        }*/

        $user->first_name = $data['first_name'];
        $user->last_name  = $data['last_name'];
        $user->email      = $data['email'];

        if ( ! empty($data['password']))
        {
            $user->password   = $data['password'];
        }

        $user->activated  = $data['activated'];
        $user->save();
// Si el usuario es sucursal entonces se le asigna
        /*if ($data['group_id'] == 2) 
        {
            // Asigna la sucursal
            $store = Store::find($data['store_id']);
            $store->user_id = $user->id;
            $store->save();
        }*/

        if ($data['store_id'])
        {
            $store_user = DB::table('store_user')
            ->where('user_id', $user->id)->first();
            if ($store_user) {
                DB::table('store_user')
                ->where('id', 1)
                ->update(array('votes' => 1));
            }else{
                DB::table('store_user')->insert(array("user_id"=>$user->id,"store_id"=>$data['store_id']));
            }
        }

        Flash::success(trans('messages.flash.updated'));

        return Redirect::route('users.index', $company);
    }


    private function profileOptions()
    {
        $options = [
            '' => 'Perfil de usuario'
        ];

        $groups = Sentry::findAllGroups();

        $allowedByGroup = [
            'admin' => [
                'Administrador',
                'Empresa',
                'Sucursal',
                'Cliente',
                'Barbero'
            ],
            'company' => [
                'Administrador',
                'Sucursal',
                #'Cliente'
            ],
            'store' => [
                'Cliente'
            ]
        ];

        foreach($groups as $group)
        {
            if ($this->user->hasAccess('company') and in_array($group->name, $allowedByGroup['company']))
            {
                $options[$group->id] = $group->name;
            }
        }

        return $options;
    }


}
