<?php namespace Barber\Repositories\Appointment;
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
use \Barber\Repositories\Appointment\Exceptions\OverlappingAppointmentException;

/**
 * Class EloquentAppointmentRepository
 * @package Barber\Repositories\Appointment
 */
class EloquentAppointmentRepository implements AppointmentRepository, CountableInterface, SortableInterface {

    /**
     * @var Appointment
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
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($appointment_id)
    {
        if ( ! $appointment = $this->appointment->find($appointment_id))
        {
            throw new ResourceNotFoundException("The appointment with the ID: {$appointment_id} does not exists.");
        }

        return $appointment;
    }

    /**
     * Crea una cita
     *
     * @param array $data
     * @return mixed|void
     * @throws ResourceOnCreateException
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        $this->checkOverlap($data['start'], $data['end'], $data['barber_id'], $data['store_id']);

        try
        {
            $appointment = $this->appointment->create($data);
        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceOnCreateException('There was an error while creating the appointment.');
        }

        DB::commit();

        return $appointment;
    }

    /**
     * Actualiza la información de la cita
     *
     * @param $appointment_id
     * @param array $data
     * @return mixed|void
     * @throws Exception
     */
    public function update($appointment_id, array $data)
    {
        $appointment = $this->getById($appointment_id);

        $barber_id = ( ! empty($data['barber_id']) and $data['barber_id'] == 'pending' ) ? null : ( ! empty($data['barber_id']) ? $data['barber_id'] : $appointment->barber_id);

        $appointment->start       = empty($data['start']) ? $appointment->start : $data['start'];
        $appointment->end         = empty($data['end']) ? $appointment->end : $data['end'];
        $appointment->status      = empty($data['status']) ? $appointment->status : $data['status'];
        // TODO : las citas no se pueden cambiar entre sucursal aún
        $appointment->barber_id   = $barber_id;

        $this->checkOverlapForUpdate($appointment_id, $appointment->start, $appointment->end, $barber_id, $appointment->store_id);

        $appointment->save();

        return $appointment;
    }

    /**
     * Obtiene todas las citas
     *
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param null $from
     * @param null $to
     * @param null $barber
     * @param null $store
     * @param null $appointment
     * @return mixed|void
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $from = null, $to = null, $barber = null, $store = null, $appointment = null)
    {
        $this->query = $this->appointment;

        if ( ! empty($from) and ! empty($to))
        {
            #$this->query = $this->query->between($from, $to);
            $this->query = $this->query->onDate($from, $to);
        }

        if ( ! empty($barber))
        {
            $this->query = $this->query->byBarber($barber);
        }

        if ( ! empty($store))
        {
            $this->query = $this->query->byStore($store);
        }

        if ( ! empty($customer))
        {
            $this->query = $this->query->byCustomer($customer);
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
        $this->query = $this->query->available()->get();


        # Retorna los registros en forma de arreglo de objetos
        return $this->query->all();
    }

    /**
     * Cancela la cita cambiando el status
     *
     * @param $appointment_id
     * @return mixed
     */
    public function cancel($appointment_id)
    {
        $data['status'] = 'canceled';

        $appointment = $this->update($appointment_id, $data);

        return $appointment;
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
     * @param $start
     * @param $end
     * @param $barber_id
     * @param $store_id
     * @throws OverlappingAppointmentException
     */
    public function checkOverlap($start, $end, $barber_id, $store_id)
    {
        $appointments = $this->appointment->isOverlapping($start, $end)->byBarber($barber_id)->byStore($store_id)->available()->get();

        #SELECT * FROM appointments WHERE '2015-09-07 09:00:00' < end AND '2015-09-07 11:00:00' > start and barber_id = 3;

        if ($appointments->count())
        {
            throw new OverlappingAppointmentException('Ya existe una cita registrada para esta hora.');
        }
    }

    /**
     * @param $start
     * @param $end
     * @param $barber_id
     * @param $store_id
     * @throws OverlappingAppointmentException
     */
    public function checkOverlapForUpdate($current_appointment_id, $start, $end, $barber_id, $store_id)
    {
        $appointments = $this->appointment->isOverlapping($start, $end)->byBarber($barber_id)->byStore($store_id)->whereNotIn('id', [$current_appointment_id])->available()->get();

        #SELECT * FROM appointments WHERE '2015-09-07 09:00:00' < end AND '2015-09-07 11:00:00' > start and barber_id = 3 and id not in(id_cita);

        if ($appointments->count())
        {
            throw new OverlappingAppointmentException('Ya existe una cita registrada para esta hora.');
        }
    }

}
