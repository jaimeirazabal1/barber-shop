<?php

/**
 * Class CategoryService
 */
class CategoryService extends \Eloquent {

    /**
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'slug' => '',
        'company_id' => 'integer'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'company_id'
    ];

    /**
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo('Company');
    }

    /**
     * @return mixed
     */
    public function services()
    {
        return $this->hasMany('Service');
    }

}