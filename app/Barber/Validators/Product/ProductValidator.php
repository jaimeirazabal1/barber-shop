<?php namespace Barber\Validators\Product;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 8/2/15
     * Time: 3:04 PM
     */


/**
 * Interface ProductValidator
 * @package Barber\Validators\Product
 */
interface ProductValidator {

    /**
     * @param array $data
     * @return mixed
     */
    public function validateForCreate(array $data);

    /**
     * @param $product_id
     * @param array $data
     * @return mixed
     */
    public function validateForUpdate($product_id, array $data);
}