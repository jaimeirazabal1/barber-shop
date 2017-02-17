<?php namespace Barber\Repositories\Company;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 7/30/15
     * Time: 12:10 PM
     */


/**
 * Interface CompanyRepository
 * @package Barber\Repositories\Company
 */
interface CompanyRepository {

    /**
     * @param $company_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($company_id);

    /**
     * @param $company_slug
     * @return mixed
     */
    public function getBySlug($company_slug);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $company_id
     * @param array $data
     * @return mixed
     */
    public function update($company_id, array $data);

    /**
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param array $filter
     * @return mixed
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $filter = null);

}


