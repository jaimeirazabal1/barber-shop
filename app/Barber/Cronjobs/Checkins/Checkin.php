<?php namespace Barber\Cronjobs\Checkins;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 10/6/15
 * Time: 10:33 PM
 */


use \Company;
use \Carbon\Carbon as Carbon;
use \DB;
use \Checkin as CheckinRepo;

class Checkin {

    /**
     * @var Company
     */
    private $company;
    /**
     * @var CheckinRepo
     */
    private $checkin;

    /**
     * @param Company $company
     * @param CheckinRepo $checkin
     */
    public function __construct(Company $company, CheckinRepo $checkin)
    {
        $this->company = $company;
        $this->checkin = $checkin;
    }


    /**
     * Actualiza las entradas faltantes de los barberos
     *
     */
    public function update()
    {
        $yesterday_date = Carbon::now()->subDay();

        # Barberos por sucursal y empresa con checkins del dia
        $companies = $this->company->with(['stores.barbers.checkins' => function($query) use ($yesterday_date)
        {
            $query->where(DB::raw('DATE(checkin)'), '=', $yesterday_date->toDateString());
        }])->get();

        foreach($companies as $company)
        {
            foreach($company->stores as $store)
            {
                foreach($store->barbers as $barber)
                {
                    if ( count($barber->checkins) == 0)
                    {
                        $this->checkin->create([
                            'checkin' => $yesterday_date->toDateString() . ' 23:59:00',
                            'store_id' => $store->id,
                            'barber_id' => $barber->id,
                            'lat' => null,
                            'lng' => null,
                            'status' => 'absence'
                        ]);
                    }
                }
            }
        }
    }
}