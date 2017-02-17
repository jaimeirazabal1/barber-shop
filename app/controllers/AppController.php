<?php
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 9/12/15
 * Time: 10:35 PM
 */


class AppController extends \BaseController {

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
        $this->user    = Session::get('user');
    }
}