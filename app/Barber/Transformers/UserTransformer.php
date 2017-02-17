<?php namespace Barber\Transformers;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:18 PM
     */


/**
 * Class UserTransformer
 * @package Barber\Transformers
 */
class UserTransformer extends Transformer {

    /**
     * @param $user
     * @return array
     */
    public function transform($user)
    {
        return [
            'id'               => $user->id,
            'first_name'       => $user->first_name,
            'last_name'        => $user->last_name,
            'fullname'         => $user->first_name . ' ' . $user->last_name,
            'email'            => $user->email,
            'active'           => (boolean) $user->activated,
            'created_at'       => $user->created_at
        ];
    }

}