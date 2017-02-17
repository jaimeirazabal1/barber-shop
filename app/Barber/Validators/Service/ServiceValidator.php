<?php namespace Barber\Validators\Service;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 8/2/15
     * Time: 3:04 PM
     */


/**
 * Interface ServiceValidator
 * @package Barber\Validators\Service
 */
interface ServiceValidator {

    /**
     * @param array $data
     * @return mixed
     */
    public function validateForCreate(array $data);

    /**
     * @param $service_id
     * @param array $data
     * @return mixed
     */
    public function validateForUpdate($service_id, array $data);
}