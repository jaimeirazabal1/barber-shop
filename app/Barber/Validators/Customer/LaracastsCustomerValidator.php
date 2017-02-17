<?php namespace Barber\Validators\Customer;
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
 * Class CustomerValidator
 * @package Barber\Validators\Customer
 */
class LaracastsCustomerValidator extends FormValidator implements CustomerValidator {


    /**
     * @var array
     */
    protected $rules = [
        'first_name' => 'required',
        'last_name' => '',
        'aka' => '',
        'birthdate' => '',
        'email' => 'email|unique:customers|unique:users',
        'phone' => '',
        'cellphone' => '',
        'notes' => '',
        'barber_id' => '',
        'user_id' => '',
        'company_id' => 'required',
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
     * @param $customer_id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function validateForUpdate($customer_id, array $data)
    {
        $this->rules['first_name']   = '';
        $this->rules['last_name']    = '';
        $this->rules['aka']          = '';
        $this->rules['birthdate']    = '';
        $this->rules['phone']        = '';
        $this->rules['cellphone']    = '';
        $this->rules['notes']        = '';
        $this->rules['barber_id']    = '';
        $this->rules['user_id']      = '';
        $this->rules['company_id']   = '';

        try
        {
            return $this->excludeId($customer_id)->validate($data);
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
    public function excludeId($id)
    {
        $this->rules['email']              = "unique:customers,email,$id";

        return $this;
    }
}