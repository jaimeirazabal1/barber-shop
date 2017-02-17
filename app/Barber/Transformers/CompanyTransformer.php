<?php namespace Barber\Transformers;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:18 PM
     */


/**
 * Class CompanyTransformer
 * @package Barber\Transformers
 */
class CompanyTransformer extends Transformer {

    /**
     * @param $company
     * @return array
     */
    public function transform($company)
    {
        return [
            'id'               => $company->id,
            'name'             => $company->name,
            'slug'             => $company->slug,
            //'owner'            => $company->owner,
        ];
    }

}