<?php namespace Barber\Validators\Customer;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 8/2/15
     * Time: 3:04 PM
     */


/**
 * Interface CustomerValidator
 * @package Barber\Validators\Customer
 */
interface CustomerValidator {

    /**
     * @param array $data
     * @return mixed
     */
    public function validateForCreate(array $data);

    /**
     * @param $customer_id
     * @param array $data
     * @return mixed
     */
    public function validateForUpdate($customer_id, array $data);
}