<?php namespace Barber\Repositories\Service;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 7/30/15
     * Time: 12:10 PM
     */


/**
 * Interface ServiceRepository
 * @package Barber\Repositories\Service
 */
interface ServiceRepository {

    /**
     * @param $service_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($service_id);

    /**
     * @param $company_id
     * @return mixed
     */
    public function getByCompany($company_id);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $service_id
     * @param array $data
     * @return mixed
     */
    public function update($service_id, array $data);

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


