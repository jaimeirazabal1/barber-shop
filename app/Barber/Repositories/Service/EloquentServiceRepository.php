<?php namespace Barber\Repositories\Service;
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
use \Service;

/**
 * Class EloquentServiceRepository
 * @package Barber\Repositories\Service
 */
class EloquentServiceRepository implements ServiceRepository, CountableInterface, SortableInterface, FilterableInterface {

    /**
     * @var Company
     */
    protected $service;

    /**
     * @var
     */
    protected $query;

    /**
     * @var
     */
    protected $count;

    /**
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param $service_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($service_id)
    {
        if ( ! $service = $this->service->find($service_id))
        {
            throw new ResourceNotFoundException("The service with the ID: {$service_id} does not exists.");
        }

        return $service;
    }

    /**
     * @param $company_id
     * @return mixed
     */
    public function getByCompany($company_id)
    {
        return $this->service->byCompany($company_id)->ordered()->get();
    }


    /**
     * Crea un servicio
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
            $service = $this->service->create($data);
        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceOnCreateException('There was an error while creating the service.');
        }

        DB::commit();

        return $service;
    }

    /**
     * Actualiza la información del servicio
     *
     * @param $service_id
     * @param array $data
     * @return mixed|void
     * @throws Exception
     */
    public function update($service_id, array $data)
    {
        $service = $this->getById($service_id);

        $service->name           = empty($data['name']) ? $service->name : $data['name'];
        $service->code           = empty($data['code']) ? $service->code : $data['code'];
        $service->price          = empty($data['price']) ? $service->price : $data['price'];
        $service->image          = empty($data['image']) ? $service->image : $data['image'];
        $service->active         = isset($data['active']) ? $data['active'] : $service->active;
        $service->order          = empty($data['order']) ? $service->order : $data['order'];
        $service->estimated_time = empty($data['estimated_time']) ? $service->estimated_time : $data['estimated_time'];
        $service->save();

        return $service;
    }

    /**
     * Obtiene todos los servicios
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
        $this->query = $this->service;

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
        $this->query = $this->service->filter($filter);

        return $this->query;
    }

}