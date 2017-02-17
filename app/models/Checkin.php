<?php

/**
 * Class Barber
 */
class Checkin extends \Eloquent {

    /**
     * @var array
     */
    protected $fillable = [
        'checkin',
        'store_id',
        'barber_id',
        'lat',
        'lng',
        'status',
        'type'
    ];

    /**
     * @return array
     */
    public function getDates()
    {
        return [
            'checkin',
            'created_at',
            'updated_at'
        ];
    }


    /**
     * Barbero que hizo el checkin
     *
     * @return mixed
     */
    public function barber()
    {
        return $this->belongsTo('Barber');
    }


    /**
     * Sucursal en la que hizo el checkin
     *
     * @return mixed
     */
    public function store()
    {
        return $this->belongsTo('Store');
    }

    /**
     * Obtiene los checkins por sucursal
     *
     * @param $query
     * @param $store_id
     * @return mixed
     */
    public function scopeByStore($query, $store_id)
    {
        return $query->where('store_id', $store_id);
    }

    /**
     * Obtiene los checkins por barbero
     *
     * @param $query
     * @param $barber_id
     * @return mixed
     */
    public function scopeByBarber($query, $barber_id)
    {
        return $query->where('barber_id', $barber_id);
    }

    /**
     * @param $query
     * @param $from
     * @param $to
     * @return mixed
     */
    public function scopeBetween($query, $from, $to)
    {
        return $query->whereBetween(\DB::raw('DATE(checkin)'), [$from, $to]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeLatests($query)
    {
        return $query->orderBy('checkin', 'desc');
    }

}