<?php

/**
 * Class Supplier
 */
class Supplier extends \Eloquent {

    /**
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'email',
        'phone' => '',
        'address' => '',
        'company_id' => 'integer'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'company_id'
    ];

    /**
     * Productos del proveedor
     *
     * @return mixed
     */
    public function products()
    {
        return $this->hasMany('Product');
    }
}