<?php namespace Barber\Validators\Appointment;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 8/2/15
     * Time: 3:04 PM
     */


/**
 * Interface AppointmentValidator
 * @package Barber\Validators\Appointment
 */
interface AppointmentValidator {

    /**
     * @param array $data
     * @return mixed
     */
    public function validateForCreate(array $data);

    /**
     * @param $appointment_id
     * @param array $data
     * @return mixed
     */
    public function validateForUpdate($appointment_id, array $data);
}