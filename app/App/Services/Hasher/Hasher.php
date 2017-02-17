<?php namespace App\Services\Hasher;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/26/15
 * Time: 3:48 PM
 */


/**
 * Interface Hasher
 * @package App\Services\Hasher
 */
interface Hasher {

    /**
     * @param $id
     * @return mixed
     */
    public function encode($id);


    /**
     * @param $hash
     * @return mixed
     */
    public function decode($hash);

}