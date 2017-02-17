<?php namespace Admin;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/26/15
 * Time: 4:38 PM
 */

use \View;
use \Session;
use \Company as Company;
use \User;

/**
 * Class UsersController
 * @package Admin
 */
class UsersController extends AdminController {


    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('users');
    }

    /**
     * Display a listing of users
     *
     * @return Response
     */
    public function index()
    {
        $users = User::paginate(25);

        return View::make('admin.modules.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.modules.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = Input::all(), User::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        User::create($data);

        return Redirect::route('users.index');
    }



    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return View::make('admin.modules.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($data = Input::all(), User::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user->update($data);

        return Redirect::route('users.index');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        return Redirect::route('users.index');
    }

}
