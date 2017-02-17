<?php namespace Barber\Transformers;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:18 PM
     */


/**
 * Class StoreTransformer
 * @package Barber\Transformers
 */
class StoreTransformer extends Transformer {

    /**
     * @param $store
     * @return array
     */
    public function transform($store)
    {
        return [
            'id'               => $store->id,
            'name'             => $store->name,
            'slug'             => $store->slug,
            'address'          => $store->address,
            'formatted_address'=> $store->formatted_address,
            'phone'            => $store->phone,
            'email'            => $store->email,
            'lat'              => $store->lat,
            'lng'              => $store->lng,
            'is_matrix'        => (bool) $store->is_matrix,
            'tolerance_time'   => (int) $store->tolerance_time,
            'start_appointments' => $store->start_appointments,
            'end_appointments' => $store->end_appointments
        ];
    }

}