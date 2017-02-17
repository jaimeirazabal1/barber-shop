<?php namespace Barber\Repositories\Product;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 7/30/15
     * Time: 12:10 PM
     */


/**
 * Interface ProductRepository
 * @package Barber\Repositories\Product
 */
interface ProductRepository {

    /**
     * @param $product_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($product_id);


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
     * @param $product_id
     * @param array $data
     * @return mixed
     */
    public function update($product_id, array $data);

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


