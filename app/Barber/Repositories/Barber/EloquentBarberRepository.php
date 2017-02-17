<?php namespace Barber\Repositories\Barber;
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
use \Barber;

/**
 * Class EloquentBarberRepository
 * @package Barber\Repositories\Barber
 */
class EloquentBarberRepository implements BarberRepository, CountableInterface, SortableInterface, FilterableInterface {

    /**
     * @var Company
     */
    protected $barber;

    /**
     * @var
     */
    protected $query;

    /**
     * @var
     */
    protected $count;

    /**
     * @param Barber $barber
     */
    public function __construct(Barber $barber)
    {
        $this->barber = $barber;
    }

    /**
     * @param $barber_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($barber_id)
    {
        if ( ! $barber = $this->barber->find($barber_id))
        {
            throw new ResourceNotFoundException("The barber with the ID: {$barber_id} does not exists.");
        }

        return $barber;
    }

    /**
     * @param $store_id
     * @return mixed
     */
    public function getByStore($store_id)
    {
        return $this->barber->byStore($store_id)->ordered()->active()->get();
    }


    /**
     * @param $code
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getByCode($code)
    {
        if ( ! $barber = $this->barber->byCode($code)->first())
        {
            throw new ResourceNotFoundException("The barber with the Code: {$code} does not exists.");
        }

        return $barber;
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
            $barber = $this->barber->create($data);
        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceOnCreateException('There was an error while creating the barber.');
        }

        DB::commit();

        return $barber;
    }

    /**
     * Actualiza la información del barbero
     *
     * @param $barber_id
     * @param array $data
     * @return mixed|void
     * @throws Exception
     */
    public function update($barber_id, array $data)
    {
        $barber = $this->getById($barber_id);

        $barber->first_name  = empty($data['first_name']) ? $barber->first_name : $data['first_name'];
        $barber->last_name   = empty($data['last_name']) ? $barber->last_name : $data['last_name'];
        $barber->address     = empty($data['address']) ? $barber->address : $data['address'];
        $barber->phone       = empty($data['phone']) ? $barber->phone : $data['phone'];
        $barber->cellphone   = empty($data['cellphone']) ? $barber->cellphone : $data['cellphone'];
        $barber->email       = empty($data['email']) ? $barber->email : $data['email'];
        $barber->color       = empty($data['color']) ? $barber->color : $data['color'];
        $barber->code        = empty($data['code']) ? $barber->code : $data['code'];
        $barber->salary_type = empty($data['salary_type']) ? $barber->salary_type : $data['salary_type'];
        $barber->salary      = empty($data['salary']) ? $barber->salary : $data['salary'];
        $barber->active      = isset($data['active']) ? $data['active'] : $barber->active;
        $barber->save();

        return $barber;
    }

    /**
     * Obtiene todos los barberos
     *
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param array $filter
     * @param null $company
     * @param null $store
     * @return mixed|void
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $filter = null, $company = null, $store = null)
    {
        $this->query = $this->barber;

        # Aplica el filtro de búsqueda
        if ( ! empty($filter))
        {
            $this->query = $this->filter($filter);
        }

        if ( ! empty($company))
        {
            $this->query = $this->query->byCompany($company);
        }

        if ( ! empty($store))
        {
            $this->query = $this->query->byStore($store);
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
        $this->query = $this->barber->filter($filter);

        return $this->query;
    }

}