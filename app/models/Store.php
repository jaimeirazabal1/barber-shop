<?php

/**
 * Class Company
 */
class Store extends \Eloquent {

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'address',
        'formatted_address',
        'phone',
        'email',
        'lat',
        'lng',
        'is_matrix',
        'active',
        'order',
        'tolerance_time',
        'company_id',
        'start_appointments',
        'end_appointments',
        'user_id'
    ];

    /**
     *
     * Empresa
     *
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo('Company');
    }

    /**
     * Barberos de la sucursal
     *
     * @return mixed
     */
    public function barbers()
    {
        return $this->hasMany('Barber');
    }


    /**
     * @return mixed
     */
    public function checkins()
    {
        return $this->hasMany('Checkin');
    }

    /**
     * Citas de la sucursal
     *
     * @return mixed
     */
    public function appointments()
    {
        return $this->hasMany('Appointment');
    }

    /**
     * Horarios de la Sucursal
     *
     * @return mixed
     */
    public function schedules()
    {
        return $this->hasMany('Schedule');
    }

    /**
     * @return mixed
     */
    public function products()
    {
        return $this->belongsToMany('Product')->withTimestamps()->withPivot('id', 'stock');
    }

    /**
     * Busca las sucursales que pertenezcan a la empresa identificada por $company_id
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
     * Busca la sucursal identificada por su slug
     *
     * @param $query
     * @param $store_slug
     * @return mixed
     */
    public function scopeBySlug($query, $store_slug)
    {
        return $query->where('slug', $store_slug);
    }

    /**
     * Ordena las sucursales por nombre en forma ascendente
     *
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

        return $query->where('name', 'LIKE', $term)
                    ->orWhere('email', 'LIKE', $term)
                    ->orWhere('address', 'LIKE', $term);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

}