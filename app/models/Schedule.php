<?php

/**
 * Class Schedule
 */
class Schedule extends \Eloquent {


    /**
     * @var array
     */
    protected $fillable = [
        'day',
        'opening',
        'closing',
        'opening_appointments',
        'closing_appointments',
        'checkin_limit',
        'store_id',
    ];

    /**
     * Sucursal
     *
     * @return mixed
     */
    public function store()
    {
        return $this->belongsTo('Store');
    }


    /**
     * @param $query
     * @param $day
     * @return mixed
     */
    public function scopeOnDay($query, $day)
    {
        return $query->where('day', $day);
    }

    /**
     * @param $query
     * @param $store_id
     * @return mixed
     */
    public function scopeByStore($query, $store_id)
    {
        return $query->where('store_id', $store_id);
    }

}