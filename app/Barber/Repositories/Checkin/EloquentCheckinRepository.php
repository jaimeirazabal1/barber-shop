<?php namespace Barber\Repositories\Checkin;
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
use \Checkin;

/**
 * Class EloquentBarberRepository
 * @package Barber\Repositories\Barber
 */
class EloquentCheckinRepository implements CheckinRepository, CountableInterface, SortableInterface {

    /**
     * @var Company
     */
    protected $checkin;

    /**
     * @var
     */
    protected $query;

    /**
     * @var
     */
    protected $count;

    /**
     * @param Checkin $checkin
     */
    public function __construct(Checkin $checkin)
    {
        $this->checkin = $checkin;
    }

    /**
     * @param $checkin_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($checkin_id)
    {
        if ( ! $checkin = $this->checkin->find($checkin_id))
        {
            throw new ResourceNotFoundException("The checkin with the ID: {$checkin_id} does not exists.");
        }

        return $checkin;
    }

    /**
     * Crea una entrada en el checador
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
            $checkin = $this->checkin->create($data);
        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceOnCreateException('There was an error while creating the checkin.');
        }

        DB::commit();

        return $checkin;
    }

    /**
     * Obtiene todos los checkins
     *
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param null $from
     * @param null $to
     * @param null $barber
     * @param null $store
     * @return mixed|void
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $from = null, $to = null, $barber = null, $store = null)
    {
        $this->query = $this->checkin;

        if ( ! empty($from) and ! empty($to))
        {
            $this->query = $this->query->between($from, $to);
        }


        if ( ! empty($barber))
        {
            $this->query = $this->query->byBarber($barber);
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

}