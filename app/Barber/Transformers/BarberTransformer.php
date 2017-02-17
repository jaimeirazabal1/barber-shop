<?php namespace Barber\Transformers;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:18 PM
     */


/**
 * Class BarberTransformer
 * @package Barber\Transformers
 */
class BarberTransformer extends Transformer {

    /**
     * @param $barber
     * @return array
     */
    public function transform($barber)
    {
        return [
            'id'          => $barber->id,
            'first_name'  => $barber->first_name,
            'last_name'   => $barber->last_name,
            'address'     => $barber->address,
            'phone'       => $barber->phone,
            'cellphone'   => $barber->cellphone,
            'email'       => $barber->email,
            'color'       => $barber->color,
            'code'        => $barber->code,
            'salary_type' => $barber->salary_type,
            'salary'      => (integer) $barber->salary,
            'active'      => (bool) $barber->active,
        ];
    }

}