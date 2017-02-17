<?php namespace Barber\Validators\Store;
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
 * Class LaracastsStoreValidator
 * @package Barber\Validators\Store
 */
class LaracastsStoreValidator extends FormValidator implements StoreValidator {


    /**
     * @var array
     */
    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:stores',
        'address' => 'required',
        'formatted_address' => 'required',
        'phone' => '',
        'email' => '',
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
        'is_matrix' => '',
        'active' => '',
        'order' => 'integer',
        'tolerance_time' => 'required|integer|min:0',
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
     * @param $store_id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function validateForUpdate($store_id, array $data)
    {
        $this->rules['name']              = "";
        $this->rules['address']           = '';
        $this->rules['formatted_address'] = '';
        $this->rules['phone']             = '';
        $this->rules['email']             = '';
        $this->rules['lat']               = 'numeric';
        $this->rules['lng']               = 'numeric';
        $this->rules['is_matrix']         = '';
        $this->rules['active']            = '';
        $this->rules['order']             = 'integer';
        $this->rules['tolerance_time']    = 'integer|min:0';
        $this->rules['company_id']        = '';


        try
        {
            return $this->excludeId($store_id)->validate($data);
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
        $this->rules['slug']              = "unique:stores,slug,$id";

        return $this;
    }
}