<?php namespace Barber\Repositories\Appointment\Service;
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
use \Appointment;


/**
 * Class EloquentServiceRepository
 * @package Barber\Repositories\Appointment\Service
 */
class EloquentServiceRepository implements ServiceRepository  {

    /**
     * @var Service
     */
    protected $appointment;

    /**
     * @var
     */
    protected $query;

    /**
     * @var
     */
    protected $count;

    /**
     * @param Appointment $appointment
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * @param $appointment_id
     * @param $service_id
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getById($appointment_id, $service_id)
    {
        if ( ! $service = $this->appointment->with(['services' => function($query) use ($service_id) {
            $query->where('appointment_service.service_id', $service_id);
        }])->find($appointment_id))
        {
            throw new ResourceNotFoundException("The appointment with the ID: {$appointment_id} does not exists.");
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
     * @param $appointment_id
     * @param array $data
     * @return mixed|void
     * @throws ResourceOnCreateException
     */
    public function create($appointment_id, array $data)
    {
        DB::beginTransaction();

        try
        {
            if ( ! $appointment = $this->appointment->find($appointment_id))
            {
                throw new ResourceNotFoundException("The appointment with the ID: {$appointment_id} does not exists.");
            }

            // TODO : validar que no se repitan los servicios
            $appointment->services()->attach($data['service_id'], ['estimated_time' => $data['estimated_time']]);

            $service = $this->appointment->with(['services' => function($query) use ($data) {
                $query->where('appointment_service.service_id', $data['service_id']);
            }])->find($appointment_id);

            $service = $service->services[0];

        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceOnCreateException('There was an error while creating the appointment.' . $e->getMessage());
        }

        DB::commit();

        return $service;
    }

    /**
     * Actualiza la información del servicio
     *
     * @param $appointment_id
     * @param $id
     * @param array $data
     * @return mixed|void
     * @throws ResourceNotFoundException
     */
    public function update($appointment_id, $id, array $data)
    {
        // TODO : limpiar cochinero XD

        # Encuentra el servicio por cliente
        if ( ! $appointment = $this->appointment->with(['services' => function($query) use ($id) {
            $query->where('appointment_service.service_id', $id);
        }])->find($appointment_id))
        {
            throw new ResourceNotFoundException("The appointment with the ID: {$appointment_id} does not exists.");
        }

        # Si n hay servicio manda un error
        if ( empty($appointment->services[0]))
        {
            throw new ResourceNotFoundException("The service with the ID: {$id} does not exists.");
        }

        # almacena temporalmente el servicio obtenido
        $service = $appointment->services[0];

        # guarda el nuevo valor del tiempo estimado del servicio
        $estimated_time = empty($data['estimated_time']) ? $appointment->services[0]->pivot->estimated_time : $data['estimated_time'];

        # actualiza el tiempo estimado en la base de datos
        $appointment->services()->updateExistingPivot($id, [
            'estimated_time' => $estimated_time
            // TODO : agregar precio de servicio
        ]);

        # establece el nuevo valor de tiempo estimado en el valor temporal, asi se evitar consultar la bd de nuevo
        $service->pivot->estimated_time = $estimated_time;

        return $service;
    }

    /**
     * @param $appointment_id
     * @param array $services
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function updateOrCreate($appointment_id, array $services)
    {
        // TODO : limpiar cochinero XD

        # Encuentra el servicio por cliente
        if ( ! $appointment = $this->appointment->with('services')->find($appointment_id))
        {
            throw new ResourceNotFoundException("The appointment with the ID: {$appointment_id} does not exists.");
        }

        $services_appointment = array();

        foreach($services as $service)
        {
            $service_id = $service['service']['id'];
            $services_appointment[$service_id] = [
                'estimated_time' => $service['estimated_time']
            ];
        }

        $appointment->services()->sync($services_appointment);

        return $service;
    }


    /**
     * @param $appointment_id
     * @return mixed|void
     * @throws ResourceNotFoundException
     */
    public function getAll($appointment_id)
    {
        if ( ! $appointment = $this->appointment->with('services')->find($appointment_id))
        {
            throw new ResourceNotFoundException("The appointment with the ID: {$appointment_id} does not exists.");
        }

        return $appointment->services->all();
    }


    /**
     * @param $appointment_id
     * @param $id
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function destroy($appointment_id, $id)
    {
        if ( ! $appointment = $this->appointment->with(['services' => function($query) use ($id) {
            $query->where('appointment_service.service_id', $id);
        }])->find($appointment_id))
        {
            throw new ResourceNotFoundException("The appointment with the ID: {$appointment_id} does not exists.");
        }

        if ( empty($appointment->services[0]))
        {
            throw new ResourceNotFoundException("The service with the ID: {$id} does not exists.");
        }

        $service = $appointment->services[0];

        $appointment->services()->detach($id);

        return $service;
    }
}