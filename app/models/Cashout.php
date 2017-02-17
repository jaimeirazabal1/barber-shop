<?php

/**
 * Class Cashout
 */
class Cashout extends \Eloquent {


    /**
     * @return array
     */
    public function getDates()
    {
        return [
            'start',
            'end',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * @var array
     */
    public static $rules = [
        'start' => 'required',
        'end' => 'required',
        'money_on_cash' => 'required|integer',
        'money_on_card' => 'required|integer',
        'withdraw' => '',
        'cash_left_on_register' => 'money',
        'store_id' => 'required|integer',
        'user_id' => '',
        'initial_register' => '',
        'tips' => ''
	];


    /**
     * @var array
     */
    protected $fillable = [
        'start',
        'end',
        'money_on_cash',
        'money_on_card',
        'withdraw',
        'cash_left_on_register',
        'store_id',
        'user_id',
        'initial_register',
        'tips'
    ];

    /**
     * @param $query
     * @param $store_id
     * @return mixed
     */
    public function scopeByStore($query, $store_id)
    {
        return $query->where('store_id', $store_id);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

}