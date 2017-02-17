<?php

/**
 * Class CategoryProduct
 */
class CategoryProduct extends \Eloquent {

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
     * Productos de la categoría
     *
     * @return mixed
     */
    public function products()
    {
        return $this->hasMany('Product');
    }

}