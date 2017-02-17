<?php namespace Barber\Validators\Checkin;
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
 * Class LaracastsCheckinValidator
 * @package Barber\Validators\Checkin
 */
class LaracastsCheckinValidator extends FormValidator implements CheckinValidator {


    /**
     * @var array
     */
    protected $rules = [
        #'checkin' => 'required|date_format:Y-m-d H:i:s',
        'code'       => 'required',
        'checkin'    => 'required',
        'store_id'   => 'required',
        'barber_id'  => 'required',
        'lat'        => 'numeric',
        'lng'        => 'numeric'
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

}