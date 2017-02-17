<?php namespace Barber\Repositories\Appointment\Service;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 7/30/15
     * Time: 12:10 PM
     */


/**
 * Interface ServiceRepository
 * @package Barber\Repositories\Appointment\Service
 */
interface ServiceRepository {

    /**
     * @param $appointment_id
     * @param $service_id
     * @return mixed
     */
    public function getById($appointment_id, $service_id);

    /**
     * @param $appointment_id
     * @param array $data
     * @return mixed
     */
    public function create($appointment_id, array $data);

    /**
     * @param $appointment_id
     * @param $service_id
     * @param array $data
     * @return mixed
     */
    public function update($appointment_id, $service_id, array $data);


    /**
     * @param $appointment_id
     * @param array $services
     * @return mixed
     */
    public function updateOrCreate($appointment_id, array $services);

    /**
     * @param $appointment_id
     * @return mixed
     */
    public function getAll($appointment_id);

    /**
     * @param $appointment_id
     * @param $id
     * @return mixed
     */
    public function destroy($appointment_id, $id);

}


