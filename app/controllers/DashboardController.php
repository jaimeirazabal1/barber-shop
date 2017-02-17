<?php
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/22/15
 * Time: 2:57 PM
 */


/**
 * Class DashboardController
 * @package Admin
 */
class DashboardController extends AppController {

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Shows the Dashboard
     */
    public function index($company)
    {
        return View::make('dashboard.index');
    }

}