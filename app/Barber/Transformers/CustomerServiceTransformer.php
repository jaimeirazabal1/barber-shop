<?php namespace Barber\Transformers;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:18 PM
     */


/**
 * Class CustomerServiceTransformer
 * @package Barber\Transformers
 */
class CustomerServiceTransformer extends Transformer {

    /**
     * @param $service
     * @return array
     */
    public function transform($service)
    {
        // TODO: inyectar servicetransforrmwe para evitar código duplicado
        return [
            'id'             => $service->id,
            'name'           => $service->name,
            'code'           => $service->code,
            'price'          => (int) $service->price,
            'image'          => $service->image,
            'estimated_time' => (int) ($service->estimated_time == $service->pivot->estimated_time ? $service->estimated_time :  $service->pivot->estimated_time), # Minutes
        ];
    }

}