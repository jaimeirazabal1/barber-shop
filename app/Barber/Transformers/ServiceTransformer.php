<?php namespace Barber\Transformers;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:18 PM
     */


/**
 * Class ServiceTransformer
 * @package Barber\Transformers
 */
class ServiceTransformer extends Transformer {

    /**
     * @param $service
     * @return array
     */
    public function transform($service)
    {
        return [
            'id'             => $service->id,
            'name'           => $service->name,
            'code'           => $service->code,
            'price'          => (int) $service->price,
            'image'          => $service->image,
            'estimated_time' => (int) $service->estimated_time, # Minutes
            'active'         => (bool) $service->active,
            'order'          => (int) $service->order,
        ];
    }

}