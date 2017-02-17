<?php

use Barber\Repositories\Store\StoreRepository;
use \Carbon\Carbon as Carbon;

/**
 * Class BarbersCheckinsController
 */
class BarbersCheckinsController extends \AppController {


    /**
     * @var StoreRepository
     */
    private $store;

    /**
     * @param StoreRepository $store
     */
    public function __construct(StoreRepository $store)
    {
        parent::__construct();

        /*$this->beforeFilter('sales.list', array('only' => array('index')));
        $this->beforeFilter('sales.create', array('only' => array('create', 'store')));
        $this->beforeFilter('sales.update', array('only' => array('edit', 'update')));
        */

        $this->store       = $store;
    }

    /**
     *
     */
    public function index($company, $barber_id)
    {
        $barber = Barber::find($barber_id);

        $checkins = Checkin::byBarber($barber_id)->latests()->paginate(25);

        return View::make('barbers.checkins.index', compact('barber', 'checkins'));
    }


    public function edit($company, $barber_id, $id)
    {
        $checkin  = Checkin::find($id);
        $barber   = Barber::find($barber_id);
        $statuses = getCheckinsOptions();

        return View::make('barbers.checkins.edit', compact('checkin', 'barber', 'statuses'));
    }

    /**
     * @param $id
     */
    public function update($company, $barber_id, $id)
    {
        $data    = Input::all();
        $checkin = Checkin::find($id);

        $checkin->status = $data['status'];
        $checkin->save();

        Flash::success(trans('messages.flash.updated'));

        return Redirect::route('barbers.checkins.index', [$company, $barber_id]);
    }


}