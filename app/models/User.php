<?php


/**
 * Class User
 */
class User extends Cartalyst\Sentry\Users\Eloquent\User {


    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'activated'
    ];

    /**
     * Empresas de un usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ownedcompanies()
    {
        return $this->hasMany('Company', 'company_id');
    }

    /**
     * Empresa del Usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company()
    {
        return $this->hasOne('Company');
    }

    /**
     *
     * Usuarios de la empresa (Todos)
     *
     * @return Company Collection
     */
    public function companies()
    {
        return $this->belongsToMany('Company', 'company_user', 'company_id', 'user_id');
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

        return $query->where('email', 'LIKE', $term)
                ->orWhere('first_name', 'LIKE', $term)
                ->orWhere('last_name', 'LIKE', $term);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->hasOne('Customer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store()
    {
        return $this->hasOne('Store');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cashouts()
    {
        return $this->hasMany('Cashout');
    }

}
