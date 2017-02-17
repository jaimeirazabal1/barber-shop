<?php namespace Barber\Validators\Appointment;
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
 * Class AppointmentValidator
 * @package Barber\Validators\Appointment
 */
class LaracastsAppointmentValidator extends FormValidator implements AppointmentValidator {


    /**
     * @var array
     */
    protected $rules = [
        'start'          => 'required|date_format:Y-m-d H:i:s',
        'end'            => 'required|date_format:Y-m-d H:i:s',
        'status'         => 'required',
        'customer_id'    => 'required',
        'store_id'       => 'required',
        'barber_id'      => 'required',
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
     * @param $appointment_id
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function validateForUpdate($appointment_id, array $data)
    {
        $this->rules['start']          = 'date_format:Y-m-d H:i:s';
        $this->rules['end']            = 'date_format:Y-m-d H:i:s';
        $this->rules['status']         = '';
        $this->rules['customer_id']    = '';
        $this->rules['store_id']       = '';
        $this->rules['barber_id']      = '';

        try
        {
            return $this->excludeId($appointment_id)->validate($data);
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