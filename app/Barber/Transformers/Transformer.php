<?php namespace Barber\Transformers;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 3/19/15
 * Time: 12:19 PM
 */

/**
 * Class Transformer
 * @package Barber\Transformers
 */
abstract class Transformer implements TransformerInterface {

    /**
     * @param $model
     * @return mixed
     */
    public abstract function transform($model);


    /**
     * @param $models
     * @return mixed
     */
    public function transformCollection($models)
    {
        return array_map([$this, 'transform'], $models);
    }

}