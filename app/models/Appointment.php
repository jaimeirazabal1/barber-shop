<?php

/**
 * Class Appointment
 */
class Appointment extends \Eloquent {

    /**
     * @var array
     */
    protected $fillable = [
        'start',
        'end',
        'status',
        'customer_id',
        'store_id',
        'barber_id',
    ];

    /**
     * @return array
     */
    public function getDates()
    {
        return array('created_at','updated_at', 'start', 'end');
    }


    /**
     * Cliente que agendó la cita
     *
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo('Customer');
    }

    /**
     * Sucursal donde se agendó la cita
     *
     *
     * @return mixed
     */
    public function store()
    {
        return $this->belongsTo('Store');
    }

    /**
     * Barbero con el que se agendó la cita
     *
     * @return mixed
     */
    public function barber()
    {
        return $this->belongsTo('Barber');
    }


    /**
     * Servicios de la Cita
     *
     * @return mixed
     */
    public function services()
    {
        return $this->belongsToMany('Service','appointment_service', 'appointment_id', 'service_id')->withPivot('estimated_time')->withTimestamps();
    }

    /**
     * Obtiene las citas por cliente
     *
     * @param $query
     * @param $customer_id
     * @return mixed
     */
    public function scopeByCustomer($query, $customer_id)
    {
        return $query->where('customer_id', $customer_id);
    }

    /**
     * Obtiene las citas por sucursal
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
     * Obtiene las citas por barbero
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
        return $query->whereBetween(\DB::raw('DATE(start)'), [$from, $to]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', '<>', 'canceled');
    }


    /**
     * @param $query
     * @param $start
     * @param $end
     * @return mixed
     */
    public function scopeOnDate($query, $start, $end)
    {
        return $query->whereRaw("DATE(start) between ? and ?", array($start, $end));
    }

    /**
     * Válida si la cita se encima con otra cita
     *
     * @param $query
     * @param $start
     * @param $end
     * @return mixed
     */
    public function scopeIsOverlapping($query, $start, $end)
    {
        return $query->whereRaw('? < end', array($start))->whereRaw('? > start', array($end));
        #SELECT * FROM appointments WHERE '2015-09-07 09:00:00' < end AND '2015-09-07 11:00:00' > start and barber_id = 3;
    }

    /**
     * @return mixed
     */
    public function sale()
    {
        return $this->hasOne('Sale');
    }

}