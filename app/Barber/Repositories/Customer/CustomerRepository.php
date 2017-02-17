<?php namespace Barber\Repositories\Customer;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 7/30/15
     * Time: 12:10 PM
     */


/**
 * Interface CustomerRepository
 * @package Barber\Repositories\Customer
 */
interface CustomerRepository {

    /**
     * @param $customer_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($customer_id);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $customer_id
     * @param array $data
     * @return mixed
     */
    public function update($customer_id, array $data);

    /**
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param array $filter
     * @param null $company
     * @return mixed
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $filter = null, $company = null);

}


