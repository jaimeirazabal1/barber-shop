<?php namespace Barber\Validators\Barber;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 8/2/15
     * Time: 3:04 PM
     */


/**
 * Interface BarberValidator
 * @package Barber\Validators\Barber
 */
interface BarberValidator {

    /**
     * @param array $data
     * @return mixed
     */
    public function validateForCreate(array $data);

    /**
     * @param $barber_id
     * @param array $data
     * @return mixed
     */
    public function validateForUpdate($barber_id, array $data);
}