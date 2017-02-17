<?php

/**
 * Class Barber
 */
class Barber extends \Eloquent {

    /**
     * @return array
     */
    public function getDates()
    {
        return [
            'created_at',
            'updated_at',
            //'check_in',
            //'check_out'
        ];
    }

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'phone',
        'cellphone',
        'email',
        'color',
        'code',
        'salary_type',
        'salary',
        'active',
        'store_id',
        'company_id',
        'mealtime_in',
        'mealtime_out',
        'check_in',
        'check_out'
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }


    /**
     * Empresa en la cual trabaja el barbero
     *
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo('Company');
    }


    /**
     * Sucursal en la cual trabaja el barbero
     *
     * @return mixed
     */
    public function store()
    {
        return $this->belongsTo('Store');
    }

    /**
     * @return mixed
     */
    public function checkins()
    {
        return $this->hasMany('Checkin');
    }

    /**
     * Citas del barbero
     *
     * @return mixed
     */
    public function appointments()
    {
        return $this->hasMany('Appointment');
    }

    /**
     * Obtiene los barberos por empresa
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
     * Obtiene los barberos por sucursal
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
     * Obtiene el barbero identificado por su código
     *
     * @param $query
     * @param $code
     * @return mixed
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
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

        return $query->where('first_name', 'LIKE', $term)
            ->orWhere('last_name', 'LIKE', $term)
            ->orWhere('email', 'LIKE', $term);
    }

    /**
     * Ordena los barberos por orden alfabetico
     *
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('first_name', 'asc')->orderBy('last_name', 'asc');
    }

}