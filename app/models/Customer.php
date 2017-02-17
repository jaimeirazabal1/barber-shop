<?php

/**
 * Class Customer
 */
class Customer extends \Eloquent {

    public function getDates()
    {
        return [
            'created_at',
            'updated_at',
            'birthdate'
        ];
    }

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'aka',
        'birthdate',
        'email',
        'phone',
        'cellphone',
        'cellphone_formatted',
        'notes',
        'barber_id',
        'user_id',
        'company_id',
        'send_email_notifications',
        'send_cellphone_notifications'
    ];


    /**
     * Empresa a la que pertenece el cliente
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
     *
     * @return mixed
     */
    public function services()
    {
        return $this->belongsToMany('Service', 'customer_service', 'customer_id', 'service_id')->withPivot('estimated_time')->withTimestamps();
    }


    /**
     * Citas del cliente
     *
     * @return mixed
     */
    public function appointments()
    {
        return $this->hasMany('Appointment');
    }


    /**
     * Obtiene los clientes por empresa
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
            ->orWhere('email', 'LIKE', $term)
            ->orWhere('aka', 'LIKE', $term);
    }

    /**
     * @return mixed
     */
    public function sales()
    {
        return $this->hasMany('Sale');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

}