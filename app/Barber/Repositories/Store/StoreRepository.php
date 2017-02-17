<?php namespace Barber\Repositories\Store;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 7/30/15
     * Time: 12:10 PM
     */


/**
 * Interface StoreRepository
 * @package Barber\Repositories\Store
 */
interface StoreRepository {

    /**
     * @param $store_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($store_id);

    /**
     * @param $store_slug
     * @return mixed
     */
    public function getBySlug($store_slug);

    /**
     * @param $company_id
     * @return mixed
     */
    public function getFirst($company_id);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $store_id
     * @param array $data
     * @return mixed
     */
    public function update($store_id, array $data);

    /**
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param array $filter
     * @param null $company
     * @return mixed
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $filter = null, $company = null);


    /**
     * @param $company
     * @return mixed
     */
    public function getAll($company);

}


