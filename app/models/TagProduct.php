<?php

/**
 * Class TagProduct
 */
class TagProduct extends \Eloquent {

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
    public function products()
    {
        return $this->belongsToMany('Product');
    }

}