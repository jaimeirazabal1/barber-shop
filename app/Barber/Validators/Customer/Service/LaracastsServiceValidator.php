<?php namespace Barber\Validators\Customer\Service;
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
 * Class LaracastsServiceValidator
 * @package Barber\Validators\Customer\Service
 */
class LaracastsServiceValidator extends FormValidator implements ServiceValidator {


    /**
     * @var array
     */
    protected $rules = [
        'service_id' => 'required',
        'estimated_time' => 'required|integer'
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
     * @param $service_id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function validateForUpdate($service_id, array $data)
    {
        $this->rules['service_id'] = '';
        $this->rules['estimated_time'] = 'integer';

        try
        {
            return $this->excludeId($service_id)->validate($data);
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