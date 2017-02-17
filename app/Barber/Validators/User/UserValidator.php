<?php namespace Barber\Validators\User;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/2/15
 * Time: 3:04 PM
 */


/**
 * Interface UserValidator
 * @package Barber\Validators\User
 */
interface UserValidator {

    /**
     * @param array $data
     * @return mixed
     */
    public function validateForCreate(array $data);

    /**
     * @param $user_id
     * @param array $data
     * @return mixed
     */
    public function validateForUpdate($user_id, array $data);
}