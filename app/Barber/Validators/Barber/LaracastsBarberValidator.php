<?php namespace Barber\Validators\Barber;
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
 * Class LaracastsBarberValidator
 * @package Barber\Validators\Barber
 */
class LaracastsBarberValidator extends FormValidator implements BarberValidator {


    /**
     * @var array
     */
    protected $rules = [
        'first_name' => 'required',
        'last_name' => '',
        'address' => '',
        'phone' => '',
        'cellphone' => '',
        'email' => 'required|email',
        'color' => 'required',
        'code' => 'required',
        'salary_type' => 'required',
        'salary' => 'required|numeric',
        'active' => '',
        'store_id' => 'required',
        'company_id' => 'required'
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
     * @param $barber_id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function validateForUpdate($barber_id, array $data)
    {
        $this->rules['first_name']  = '';
        $this->rules['last_name']   = '';
        $this->rules['address']     = '';
        $this->rules['phone']       = '';
        $this->rules['cellphone']   = '';
        $this->rules['email']       = 'email';
        $this->rules['color']       = '';
        $this->rules['code']        = '';
        $this->rules['salary_type'] = '';
        $this->rules['salary']      = 'integer';
        $this->rules['active']      = '';
        $this->rules['store_id']    = '';
        $this->rules['company_id']  = '';

        try
        {
            return $this->excludeId($barber_id)->validate($data);
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
        //$this->rules['slug']              = "unique:barbers,slug,$id";

        return $this;
    }
}