<?php namespace Barber\Validators\Service;
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
 * Class ServiceValidator
 * @package Barber\Validators\Service
 */
class LaracastsServiceValidator extends FormValidator implements ServiceValidator {


    /**
     * @var array
     */
    protected $rules = [
        'name' => 'required',
        'code' => '',
        'price' => 'required|money',
        'image' => 'image',
        'active' => '',
        'order' => 'integer',
        'estimated_time' => 'integer', # Minutes
        'company_id' => ''
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
        $this->rules['name']           = '';
        $this->rules['code']           = '';
        $this->rules['price']          = 'money';
        $this->rules['image']          = 'image';
        $this->rules['active']         = '';
        $this->rules['order']          = 'integer';
        $this->rules['estimated_time'] = 'integer'; # Minutes
        $this->rules['company_id']     = '';

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