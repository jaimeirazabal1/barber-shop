<?php

/**
 * Class Company
 */
class Company extends \Eloquent {


    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'user_id'
    ];


    /**
     * @return mixed
     */
    public function owner()
    {
        return $this->belongsTo('User', 'user_id');
    }


    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany('User', 'company_user', 'company_id', 'user_id');
    }


    /**
     * @return mixed
     */
    public function stores()
    {
        return $this->hasMany('Store');
    }


    /**
     * Barberos de la empresa
     *
     * @return mixed
     */
    public function barbers()
    {
        return $this->hasMany('Barber');
    }


    /**
     * Servicios de la empresa
     *
     * @return mixed
     */
    public function services()
    {
        return $this->hasMany('Service');
    }


    /**
     * Productos de la empresa
     *
     * @return mixed
     */
    public function products()
    {
        return $this->hasMany('Product');
    }


    /**
     * Clientes de la empresa
     *
     * @return mixed
     */
    public function customers()
    {
        return $this->hasMany('Customer');
    }

    /**
     * Obtiene la empresa identificada por su slug
     *
     * @param $query
     * @param $slug
     * @return mixed
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
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
     *
     * Categorías de productos
     *
     * @return mixed
     */
    public function categoryProducts()
    {
        return $this->hasMany('CategoryProduct');
    }

    /**
     *
     * Categorías de servicios
     *
     * @return mixed
     */
    public function categoryServices()
    {
        return $this->hasMany('CategoryService');
    }

    /**
     * @return mixed
     */
    public function tagServices()
    {
        return $this->hasMany('TagService');
    }

    /**
     * @return mixed
     */
    public function tagProducts()
    {
        return $this->hasMany('TagProduct');
    }

}