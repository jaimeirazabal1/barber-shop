<?php namespace Barber\Repositories\Customer\Service;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 7/30/15
     * Time: 12:10 PM
     */


/**
 * Interface ServiceRepository
 * @package Barber\Repositories\Customer\Service
 */
interface ServiceRepository {

    /**
     * @param $customer_id
     * @param $service_id
     * @return mixed
     */
    public function getById($customer_id, $service_id);

    /**
     * @param $customer_id
     * @param array $data
     * @return mixed
     */
    public function create($customer_id, array $data);

    /**
     * @param $service_id
     * @param array $data
     * @return mixed
     */
    public function update($customer_id, $service_id, array $data);

    /**
     * @param $customer_id
     * @return mixed
     */
    public function getAll($customer_id);

    /**
     * @param $customer_id
     * @param $id
     * @return mixed
     */
    public function destroy($customer_id, $id);

}


