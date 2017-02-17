<?php namespace Admin;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/22/15
 * Time: 3:22 PM
 */

use \Session;
use \Company;


/**
 * Class AdminController
 * @package Admin
 */
class AdminController extends \BaseController {


    /**
     * @var
     */
    protected $company;

    /**
     * @var
     */
    protected $user;


    /**
     *
     */
    public function __construct()
    {
        $company = Company::findOrFail(1);
        Session::put('company', $company);

        $this->user    = Session::get('user');
        $this->company = $company;
    }

}