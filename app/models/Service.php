<?php

/**
 * Class Service
 */
class Service extends \Eloquent {

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'price',
        'image',
        'active',
        'order',
        'estimated_time', # Minutes
        'company_id',
        'category_id'
    ];


    /**
     * Empresa que ofrece el servicio
     *
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo('Company');
    }


    /**
     * Servicios del cliente
     *
     * @return mixed
     */
    public function customers()
    {
        return $this->belongsToMany('Customer', 'customer_service', 'customer_id', 'service_id')->withPivot('estimated_time')->withTimestamps();
    }


    /**
     * Citas relacionadas con el servicio
     *
     * @return mixed
     */
    public function appointments()
    {
        return $this->belongsToMany('Appointment','appointment_service', 'appointment_id', 'service_id')->withPivot('estimated_time')->withTimestamps();
    }

    /**
     * Obtiene los servicios por empresa
     *
     * @param $query
     * @param $company_id
     * @return mixed
     */
    public function scopeByCompany($query, $company_id)
    {
        return $query->where('company_id', $company_id);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }

    /**
     * Filtra los resultados de la consulta
     *
     * @param $query
     * @param $term
     */
    public function scopeFilter($query, $term)
    {
        $term = '%' . $term .  '%';

        return $query->where('name', 'LIKE', $term);
    }


    /**
     * Categoría del servicio
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo('CategoryService');
    }

    /**
     * @return mixed
     */
    public function tags()
    {
        return  $this->belongsToMany('TagService');
    }
}