<?php namespace Barber\Validators\Product;
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
 * Class ProductValidator
 * @package Barber\Validators\Product
 */
class LaracastsProductValidator extends FormValidator implements ProductValidator {


    /**
     * @var array
     */
    protected $rules = [
        'name' => 'required',
        'sku'  => 'required',
        'price' => 'required|money',
        'image' => 'image',
        'active' => '',
        'order' => 'integer',
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
     * @param $product_id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function validateForUpdate($product_id, array $data)
    {
        $this->rules['name']           = '';
        $this->rules['sku']            = '';
        $this->rules['price']          = 'numeric'; // TODO : cambiar a money
        $this->rules['image']          = 'image';
        $this->rules['active']         = '';
        $this->rules['order']          = 'integer';
        $this->rules['company_id']     = '';

        try
        {
            return $this->excludeId($product_id)->validate($data);
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