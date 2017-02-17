<?php namespace Barber\Validators\User;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/2/15
 * Time: 3:30 PM
 */

use Barber\Validators\Exceptions\ValidationException;
use Laracasts\Validation\FormValidator;
use Laracasts\Validation\FormValidationException;


/**
 * Class LaracastsUserValidator
 * @package Barber\Validators\User
 */
class LaracastsUserValidator extends FormValidator implements UserValidator {


    /**
     * @var array
     */
    protected $rules = [
        'first_name'            => 'required',
        'last_name'             => 'required',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|confirmed|min:8',
        'password_confirmation' => 'required|min:8'
    ];


    /**
     * @param array $data
     * @return mixed
     * @throws FormValidationException
     * @throws \Exception
     */
    public function validateForCreate(array $data)
    {
        try
        {
            return $this->validate($data);
        }
        catch(FormValidationException $e)
        {
            throw new ValidationException('Validation failed', $e->getErrors());
        }
    }

    /**
     * @param $user_id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function validateForUpdate($user_id, array $data)
    {
        try
        {
            return $this->excludeUserId($user_id)->validate($data);
        }
        catch(FormValidationException $e)
        {
            throw new ValidationException('Validation failed', $e->getErrors());
        }
    }

    /**
     * @param $id
     * @return $this
     */
    public function excludeUserId($id)
    {
        $this->rules['first_name'] = '';
        $this->rules['last_name'] = '';
        $this->rules['email'] = "unique:users,email,$id";
        $this->rules['password'] = "confirmed|min:8";
        $this->rules['password_confirmation'] = "min:8";

        return $this;
    }
}