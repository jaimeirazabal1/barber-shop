<?php namespace Barber\Validators\Company;
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
 * Class LaracastsCompanyValidator
 * @package Barber\Validators\Company
 */
class LaracastsCompanyValidator extends FormValidator implements CompanyValidator {


    /**
     * @var array
     */
    protected $rules = [
        'name'                  => 'required|unique:companies',
        'slug'                  => 'unique:companies',
        'user_id'               => 'required',
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
     * @param $company_id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function validateForUpdate($company_id, array $data)
    {
        try
        {
            return $this->excludeCompanyId($company_id)->validate($data);
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
    public function excludeCompanyId($id)
    {
        $this->rules['name']    = "unique:companies,name,$id";
        $this->rules['slug']    = "unique:companies,slug,$id";
        $this->rules['user_id'] = '';

        return $this;
    }
}