<?php

/**
 * Class Product
 */
class Product extends \Eloquent {

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'price',
        'image',
        'active',
        'order',
        'company_id',
        'supplier_id',
        'category_id',
    ];


    /**
     * Empresa que ofrece el producto
     *
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo('Company');
    }


    /**
     * Obtiene los productos por empresa
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
	 * Obtiene los productos por empresa
	 *
	 * @param $query
	 * @param $company_id
	 * @return mixed
	 */
	public function scopeByCategory($query, $category_id)
	{
		return $query->where('category_id', $category_id);
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

        return $query->where('name', 'LIKE', $term)
                        ->orWhere('sku', 'LIKE', $term)
	                    ->orWhere('price', 'LIKE', $term);
    }


    /**
     * @return mixed
     */
    public function sales()
    {
        return $this->belongsToMany('Sale', 'product_sale', 'sale_id', 'product_id')->withTimestamps()->withPivot('id', 'price', 'quantity');
    }

    /**
     * Categoría del producto
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo('CategoryProduct');
    }

    /**
     * Proveedor del producto
     *
     * @return mixed
     */
    public function supplier()
    {
        return $this->belongsTo('Supplier');
    }

    /**
     * @return mixed
     */
    public function tags()
    {
        return $this->belongsToMany('TagProduct');
    }

    /**
     * @return mixed
     */
    public function stores()
    {
        return $this->belongsToMany('Store')->withTimestamps()->withPivot('id', 'stock');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

}