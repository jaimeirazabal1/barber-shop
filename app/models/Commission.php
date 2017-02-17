<?php

/**
 * Class Commission
 */
class Commission extends \Eloquent {

    /**
     * @var array
     */
    public static $rules = [
        'min',
        'max',
        'percent',
        'company_id'
	];

    /**
     * @var array
     */
    protected $fillable = [
        'min',
        'max',
        'percent',
        'company_id'
    ];

    /**
     * @param $query
     * @param $company_id
     * @return mixed
     */
    public function scopeByCompany($query, $company_id)
    {
        return $query->where('company_id', $company_id);
    }

}