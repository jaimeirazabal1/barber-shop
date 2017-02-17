<?php namespace Barber\Transformers;
    /**
     * Created by Netcommerce.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:19 PM
     */


/**
 * Interface TransformerInterface
 * @package Barber\Transformers
 */
interface TransformerInterface {

    /**
     * @param $model
     * @return mixed
     */
    public function transform($model);


    /**
     * @param $models
     * @return mixed
     */
    public function transformCollection($models);

}