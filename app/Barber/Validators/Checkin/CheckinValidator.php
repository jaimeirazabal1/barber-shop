<?php namespace Barber\Validators\Checkin;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 8/2/15
     * Time: 3:04 PM
     */


/**
 * Interface CheckinValidator
 * @package Barber\Validators\Checkin
 */
interface CheckinValidator {

    /**
     * @param array $data
     * @return mixed
     */
    public function validateForCreate(array $data);

}