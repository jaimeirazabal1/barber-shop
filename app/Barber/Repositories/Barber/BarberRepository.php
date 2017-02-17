<?php namespace Barber\Repositories\Barber;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 7/30/15
     * Time: 12:10 PM
     */


/**
 * Interface BarberRepository
 * @package Barber\Repositories\Barber
 */
interface BarberRepository {

    /**
     * @param $barber_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($barber_id);

    /**
     * @param $store_id
     * @return mixed
     */
    public function getByStore($store_id);

    /**
     * @param $code
     * @return mixed
     */
    public function getByCode($code);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $barber_id
     * @param array $data
     * @return mixed
     */
    public function update($barber_id, array $data);

    /**
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param array $filter
     * @param null $company
     * @param null $store
     * @return mixed
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $filter = null, $company = null, $store = null);

}


