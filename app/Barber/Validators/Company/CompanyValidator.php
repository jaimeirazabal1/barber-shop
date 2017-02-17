<?php namespace Barber\Validators\Company;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 8/2/15
     * Time: 3:04 PM
     */


/**
 * Interface CompanyValidator
 * @package Barber\Validators\Company
 */
interface CompanyValidator {

    /**
     * @param array $data
     * @return mixed
     */
    public function validateForCreate(array $data);

    /**
     * @param $company_id
     * @param array $data
     * @return mixed
     */
    public function validateForUpdate($company_id, array $data);
}