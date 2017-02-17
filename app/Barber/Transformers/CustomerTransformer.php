<?php namespace Barber\Transformers;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:18 PM
     */


/**
 * Class CustomerTransformer
 * @package Barber\Transformers
 */
class CustomerTransformer extends Transformer {

    /**
     * @param $customer
     * @return array
     */
    public function transform($customer)
    {
        return [
            'id'         => $customer->id,
            'first_name' => $customer->first_name,
            'last_name'  => $customer->last_name,
            'aka'        => $customer->aka,
            'birthdate'  => $customer->birthdate,
            'email'      => $customer->email,
            'phone'      => $customer->phone,
            'cellphone'  => $customer->cellphone,
            'notes'      => $customer->notes,
            'notifications' => [
                'email'     => (bool) $customer->send_email_notifications,
                'cellphone' => (bool) $customer->send_cellphone_notifications,
            ]
            #'barber'     => 'Pendiente de obtener en transformer'
        ];
    }

}