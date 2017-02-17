<?php namespace Barber\Repositories\Appointment;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 7/30/15
     * Time: 12:10 PM
     */


/**
 * Interface AppointmentRepository
 * @package Barber\Repositories\Appointment
 */
interface AppointmentRepository {

    /**
     * @param $appointment_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($appointment_id);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $appointment_id
     * @param array $data
     * @return mixed
     */
    public function update($appointment_id, array $data);

    /**
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param null $from
     * @param null $to
     * @param null $barber
     * @param null $store
     * @param null $customer
     * @return mixed
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $from = null, $to = null, $barber = null, $store = null, $customer = null);

    /**
     * @param $appointment_id
     * @return mixed
     */
    public function cancel($appointment_id);

}


