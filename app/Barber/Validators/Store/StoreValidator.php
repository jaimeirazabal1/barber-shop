<?php namespace Barber\Validators\Store;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 8/2/15
     * Time: 3:04 PM
     */


/**
 * Interface StoreValidator
 * @package Barber\Validators\Store
 */
interface StoreValidator {

    /**
     * @param array $data
     * @return mixed
     */
    public function validateForCreate(array $data);

    /**
     * @param $store_id
     * @param array $data
     * @return mixed
     */
    public function validateForUpdate($store_id, array $data);
}