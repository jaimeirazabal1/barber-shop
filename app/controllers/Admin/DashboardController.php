<?php namespace Admin;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/22/15
 * Time: 2:57 PM
 */

use \View;


/**
 * Class DashboardController
 * @package Admin
 */
class DashboardController extends AdminController {

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        /*


        $this->beforeFilter('accounts.index', array('only' => array('index')));
        $this->beforeFilter('accounts.create', array('only' => array('create', 'store')));
        $this->beforeFilter('accounts.update', array('only' => array('edit', 'update')));
        $this->beforeFilter('accounts.show', array('only' => array('show')));
        */
    }

    /**
     * Shows the Dashboard
     */
    public function index()
    {
        return View::make('admin.modules.dashboard.index');
    }

}