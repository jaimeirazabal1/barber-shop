<?php namespace Barber\Repositories\Customer;
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
use \Customer;

/**
 * Class EloquentCustomerRepository
 * @package Barber\Repositories\Customer
 */
class EloquentCustomerRepository implements CustomerRepository, CountableInterface, SortableInterface, FilterableInterface {

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var
     */
    protected $query;

    /**
     * @var
     */
    protected $count;

    /**
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @param $customer_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($customer_id)
    {
        if ( ! $customer = $this->customer->find($customer_id))
        {
            throw new ResourceNotFoundException("The customer with the ID: {$customer_id} does not exists.");
        }

        return $customer;
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
            $data['last_name'] = empty($data['last_name']) ? null : $data['last_name'];
            $data['aka']       = empty($data['aka']) ? null : $data['aka'];
            $data['birthdate'] = empty($data['birthdate']) ? null : $data['birthdate'];
            $data['email']     = empty($data['email']) ? null : $data['email'];
            $data['phone']     = empty($data['phone']) ? null : $data['phone'];
            $data['cellphone'] = empty($data['cellphone']) ? null : $data['cellphone'];
            $data['cellphone_formatted'] = empty($data['cellphone_formatted']) ? null : $data['cellphone_formatted'];
            $data['notes']     = empty($data['notes']) ? null : $data['notes'];
            $data['send_email_notifications']     = empty($data['send_email_notifications']) ? false : true;
            $data['send_cellphone_notifications'] = empty($data['send_cellphone_notifications']) ? false : true;

            $customer = $this->customer->create($data);
        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceOnCreateException('There was an error while creating the customer.');
        }

        DB::commit();

        return $customer;
    }

    /**
     * Actualiza la información del customero
     *
     * @param $customer_id
     * @param array $data
     * @return mixed|void
     * @throws Exception
     */
    public function update($customer_id, array $data)
    {
        $customer = $this->getById($customer_id);

        $customer->first_name = empty($data['first_name']) ? $customer->first_name : $data['first_name'];
        $customer->last_name  = empty($data['last_name']) ? $customer->last_name : $data['last_name'];
        $customer->aka        = empty($data['aka']) ? $customer->aka : $data['aka'];
        $customer->birthdate  = empty($data['birthdate']) ? $customer->birthdate : $data['birthdate'];
        $customer->email      = empty($data['email']) ? $customer->email : $data['email'];
        $customer->phone      = empty($data['phone']) ? $customer->phone : $data['phone'];
        $customer->cellphone  = empty($data['cellphone']) ? $customer->cellphone : $data['cellphone'];
        $customer->cellphone_formatted  = empty($data['cellphone_formatted']) ? $customer->cellphone_formatted : $data['cellphone_formatted'];
        $customer->notes      = empty($data['notes']) ? $customer->notes : $data['notes'];
        $customer->barber_id  = empty($data['barber_id']) ? $customer->barber_id : $data['barber_id'];
        $customer->user_id    = empty($data['user_id']) ? $customer->user_id : $data['user_id'];
        $customer->company_id = empty($data['company_id']) ? $customer->company_id : $data['company_id'];
        $customer->send_email_notifications      = isset($data['send_email_notifications']) ? $data['send_email_notifications'] : $customer->send_email_notifications;
        $customer->send_cellphone_notifications  = isset($data['send_cellphone_notifications']) ? $data['send_cellphone_notifications'] : $customer->send_cellphone_notifications;
        $customer->save();

        return $customer;
    }

    /**
     * Obtiene todos los customeros
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
        $this->query = $this->customer;

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
        $this->query = $this->customer->filter($filter);

        return $this->query;
    }

}