<?php namespace App\Facades;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 4/1/15
 * Time: 10:31 AM
 */
use \Illuminate\Support\Facades\Facade;


/**
 * Class Hasher
 * @package App\Facades
 */
class Hasher extends Facade {


    /**
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Services\Hasher\Hasher';
    }

}