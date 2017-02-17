<?php namespace Barber\Repositories\Customer\Service;
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
 * Class EloquentServiceRepository
 * @package Barber\Repositories\Customer\Service
 */
class EloquentServiceRepository implements ServiceRepository  {

    /**
     * @var Service
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
     * @param $service_id
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getById($customer_id, $service_id)
    {
        if ( ! $service = $this->customer->with(['services' => function($query) use ($service_id) {
            $query->where('customer_service.service_id', $service_id);
        }])->find($customer_id))
        {
            throw new ResourceNotFoundException("The customer with the ID: {$customer_id} does not exists.");
        }

        if ( empty($service->services[0]))
        {
            throw new ResourceNotFoundException("The service with the ID: {$service_id} does not exists.");
        }

        $service = $service->services[0];

        return $service;
    }

    /**
     * Crea un Servicio
     *
     * @param $customer_id
     * @param array $data
     * @return mixed|void
     * @throws ResourceOnCreateException
     */
    public function create($customer_id, array $data)
    {
        DB::beginTransaction();

        try
        {
            if ( ! $customer = $this->customer->find($customer_id))
            {
                throw new ResourceNotFoundException("The customer with the ID: {$customer_id} does not exists.");
            }

            // TODO : validar que no se repitan los servicios
            $customer->services()->attach($data['service_id'], ['estimated_time' => $data['estimated_time']]);

            $service = $this->customer->with(['services' => function($query) use ($data) {
                $query->where('customer_service.service_id', $data['service_id']);
            }])->find($customer_id);

            $service = $service->services[0];

        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceOnCreateException('There was an error while creating the customer.' . $e->getMessage());
        }

        DB::commit();

        return $service;
    }

    /**
     * Actualiza la información del servicio
     *
     * @param $customer_id
     * @param $id
     * @param array $data
     * @return mixed|void
     * @throws ResourceNotFoundException
     */
    public function update($customer_id, $id, array $data)
    {
        // TODO : limpiar cochinero XD

        # Encuentra el servicio por cliente
        if ( ! $customer = $this->customer->with(['services' => function($query) use ($id) {
            $query->where('customer_service.service_id', $id);
        }])->find($customer_id))
        {
            throw new ResourceNotFoundException("The customer with the ID: {$customer_id} does not exists.");
        }

        # Si n hay servicio manda un error
        if ( empty($customer->services[0]))
        {
            throw new ResourceNotFoundException("The service with the ID: {$id} does not exists.");
        }

        # almacena temporalmente el servicio obtenido
        $service = $customer->services[0];

        # guarda el nuevo valor del tiempo estimado del servicio
        $estimated_time = empty($data['estimated_time']) ? $customer->services[0]->pivot->estimated_time : $data['estimated_time'];

        # actualiza el tiempo estimado en la base de datos
        $customer->services()->updateExistingPivot($id, [
            'estimated_time' => $estimated_time
        ]);

        # establece el nuevo valor de tiempo estimado en el valor temporal, asi se evitar consultar la bd de nuevo
        $service->pivot->estimated_time = $estimated_time;

        return $service;
    }



    /**
     * @param $customer_id
     * @return mixed|void
     * @throws ResourceNotFoundException
     */
    public function getAll($customer_id)
    {
        if ( ! $customer = $this->customer->with('services')->find($customer_id))
        {
            throw new ResourceNotFoundException("The customer with the ID: {$customer_id} does not exists.");
        }

        return $customer->services->all();
    }


    /**
     * @param $customer_id
     * @param $id
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function destroy($customer_id, $id)
    {
        if ( ! $customer = $this->customer->with(['services' => function($query) use ($id) {
            $query->where('customer_service.service_id', $id);
        }])->find($customer_id))
        {
            throw new ResourceNotFoundException("The customer with the ID: {$customer_id} does not exists.");
        }

        if ( empty($customer->services[0]))
        {
            throw new ResourceNotFoundException("The service with the ID: {$id} does not exists.");
        }

        $service = $customer->services[0];

        $customer->services()->detach($id);

        return $service;
    }
}