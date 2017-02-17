<?php namespace Barber\Validators\Exceptions;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/2/15
 * Time: 4:20 PM
 */

use Exception;


/**
 * Class ValidationException
 * @package Barber\Validators\Exceptions
 */
class ValidationException extends Exception {

    /**
     * @var
     */
    protected $errors;

    /**
     * @param string $message
     * @param mixed  $errors
     */
    function __construct($message, $errors)
    {
        $this->errors = $errors;
        parent::__construct($message);
    }
    /**
     * Get form validation errors
     *
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

}