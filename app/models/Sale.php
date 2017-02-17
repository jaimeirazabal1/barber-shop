<?php
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/19/15
 * Time: 10:56 PM
 */

class Sale extends \Eloquent {

    /**
     * @var array
     */
    protected $fillable = [
        'checkin',
        'checkout',
        'comments',
        'status',
        'appointment_id',
        'customer_id',
        'store_id',
        'total',
        'type',
        'tip'
    ];

    /**
     * @return array
     */
    public function getDates()
    {
        return [
            'checkin',
            'checkout',
            'created_at',
            'updated_at'
        ];
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     *
     *
     * @param $query
     * @param $start
     * @param $end
     * @return mixed
     */
    public function scopeOnDatetime($query, $start, $end)
    {
        return $query->whereBetween("created_at", array($start, $end));
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCash($query)
    {
        return $query->where('type', 'cash');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCard($query)
    {
        return $query->where('type', 'card');
    }

    /**
     * @return mixed
     */
    public function products()
    {
        return $this->belongsToMany('Product', 'product_sale', 'sale_id', 'product_id')->withTimestamps()->withPivot('id', 'price', 'quantity');
    }

    /**
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo('Customer');
    }

    /**
     * @return mixed
     */
    public function appointment()
    {
        return $this->belongsTo('Appointment');
    }

}

