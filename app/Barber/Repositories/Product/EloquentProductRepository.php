<?php namespace Barber\Repositories\Product;
/**
 * Created by Apptitud.mx.
 * Company: diegogonzalez
 * Date: 7/30/15
 * Time: 12:11 PM
 */

use Barber\Repositories\Exceptions\ResourceOnCreateException;
use Barber\Repositories\Exceptions\ResourceNotFoundException;
use Barber\Repositories\Exceptions\ResourceOnUpdateException;
use Exception;
use \Barber\Repositories\CountableInterface;
use \Barber\Repositories\SortableInterface;
use \Barber\Repositories\FilterableInterface;
use \DB;
use \Product;

/**
 * Class EloquentProductRepository
 * @package Barber\Repositories\Product
 */
class EloquentProductRepository implements ProductRepository, CountableInterface, SortableInterface, FilterableInterface {

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var
     */
    protected $query;

    /**
     * @var
     */
    protected $count;

    /**
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @param $product_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($product_id)
    {
        if ( ! $product = $this->product->find($product_id))
        {
            throw new ResourceNotFoundException("The product with the ID: {$product_id} does not exists.");
        }

        return $product;
    }

    /**
     * @param $company_id
     * @return mixed
     */
    public function getByCompany($company_id)
    {
        // TODO : obtener productos activos

        return $this->product->byCompany($company_id)->active()->ordered()->get();
    }


    /**
     * Crea un Barbero
     *
     * @param array $data
     * @return mixed|void
     * @throws ResourceOnCreateException
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try
        {
            $product = $this->product->create($data);
        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceOnCreateException('There was an error while creating the product.');
        }

        DB::commit();

        return $product;
    }

    /**
     * Actualiza la información del producto
     *
     * @param $product_id
     * @param array $data
     * @return mixed|void
     * @throws Exception
     */
    public function update($product_id, array $data)
    {
        $product = $this->getById($product_id);

        $product->name        = empty($data['name']) ? $product->name : $data['name'];
        $product->sku         = empty($data['sku']) ? $product->sku : $data['sku'];
        $product->price       = empty($data['price']) ? $product->price : $data['price'];
        $product->image       = empty($data['image']) ? $product->image : $data['image'];
        $product->active      = isset($data['active']) ? $data['active'] : $product->active;
        $product->order       = empty($data['order']) ? $product->order : $data['order'];
        $product->save();

        return $product;
    }

    /**
     * Obtiene todos los productos
     *
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param array $filter
     * @param null $company
     * @return mixed|void
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $filter = null, $company = null)
    {
        $this->query = $this->product;

        # Aplica el filtro de búsqueda
        if ( ! empty($filter))
        {
            $this->query = $this->filter($filter);
        }

        if ( ! empty($company))
        {
            $this->query = $this->query->byCompany($company);
        }

        # Cuenta los registros de la consulta
        $this->count = $this->query->count();

        # Toma los registros seleccionados
        $this->query = $this->query->skip($limit * ($page - 1))->take($limit);

        # Aplica el ordenamiento de columnas
        if ( ! empty($sort))
        {
            $this->query = $this->sort($sort);
        }

        # Obtiene los registros
        #$this->query = $this->query->with('owner')->get();
        $this->query = $this->query->get();


        # Retorna los registros en forma de arreglo de objetos
        return $this->query->all();
    }

    /**
     * Obtiene el número de registros totales
     *
     * @return mixed
     */
    public function count()
    {
        return $this->count;
    }


    /**
     * Crea el ordenamiento de los campos
     *
     * @param array $fields
     * @return mixed
     */
    public function sort(array $fields)
    {
        foreach($fields as $field)
        {
            $this->query = $this->query->orderBy($field['field'], $field['order']);
        }

        return $this->query;
    }

    /**
     * Aplica filtro deseado en la consulta
     *
     * @param $filter
     * @return mixed
     */
    public function filter($filter)
    {
        $this->query = $this->product->filter($filter);

        return $this->query;
    }

}