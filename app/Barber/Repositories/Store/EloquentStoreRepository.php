<?php namespace Barber\Repositories\Store;
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
use \Store;

/**
 * Class EloquentCompanyRepository
 * @package Barber\Repositories\Company
 */
class EloquentStoreRepository implements StoreRepository, CountableInterface, SortableInterface, FilterableInterface {

    /**
     * @var Company
     */
    protected $store;

    /**
     * @var
     */
    protected $query;

    /**
     * @var
     */
    protected $count;

    /**
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * @param $store_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($store_id)
    {
        if ( ! $store = $this->store->find($store_id))
        {
            throw new ResourceNotFoundException("The store with the ID: {$store_id} does not exists.");
        }

        return $store;
    }

    /**
     * @param $store_slug
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getBySlug($store_slug)
    {
        if ( ! $store = $this->store->bySlug($store_slug)->first())
        {
            throw new ResourceNotFoundException("The store with the slug: {$store_slug} does not exists.");
        }

        return $store;
    }

    /**
     * @param $company_id
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getFirst($company_id)
    {
        if ( ! $store = $this->store->byCompany($company_id)->ordered()->first())
        {
            throw new ResourceNotFoundException("The are not stores found.");
        }

        return $store;
    }


    /**
     * Crea una empresa
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
            $store = $this->store->create($data);
        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceOnCreateException('There was an error while creating the store.');
        }

        DB::commit();

        return $store;
    }

    /**
     * Actualiza la información de la empresa
     *
     * @param $store_id
     * @param array $data
     * @return mixed|void
     * @throws Exception
     */
    public function update($store_id, array $data)
    {
        $store = $this->getById($store_id);

        $store->name    = empty($data['name']) ? $store->name : $data['name'];
        $store->slug    = empty($data['slug']) ? $store->slug : $data['slug'];
        $store->address    = empty($data['address']) ? $store->address : $data['address'];
        $store->formatted_address    = empty($data['formatted_address']) ? $store->formatted_address : $data['formatted_address'];
        $store->phone    = empty($data['phone']) ? $store->phone : $data['phone'];
        $store->email    = empty($data['email']) ? $store->email : $data['email'];
        $store->lat    = empty($data['lat']) ? $store->lat : $data['lat'];
        $store->lng    = empty($data['lng']) ? $store->lng : $data['lng'];
        $store->is_matrix    = isset($data['is_matrix']) ? $data['is_matrix'] : $store->is_matrix;
        $store->active    = isset($data['active']) ? $data['active'] : $store->active;
        $store->order    = empty($data['order']) ? $store->order : $data['order'];
        $store->tolerance_time    = empty($data['tolerance_time']) ? $store->tolerance_time : $data['tolerance_time'];
        $store->start_appointments = empty($data['start_appointments']) ? $store->start_appointments : $data['start_appointments'];
        $store->end_appointments = empty($data['end_appointments']) ? $store->end_appointments : $data['end_appointments'];

        $store->save();

        return $store;
    }

    /**
     * Obtiene todos los Usuarios
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
        $this->query = $this->store;

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
        $this->query = $this->store->filter($filter);

        return $this->query;
    }

    /**
     * @param $company_id
     * @return mixed
     */
    public function getAll($company_id)
    {
        return $this->store->byCompany($company_id)->ordered()->get();
    }
}