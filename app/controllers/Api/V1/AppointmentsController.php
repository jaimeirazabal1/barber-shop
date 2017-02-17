<?php namespace Api\V1;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/30/15
 * Time: 11:06 AM
 */

use \Api\ApiController;
use Barber\Repositories\Exceptions\ResourceNotFoundException;
use Barber\Repositories\Exceptions\ResourceOnCreateException;
use Barber\Repositories\Exceptions\Sort\SortableFieldInvalid;
use \Barber\Repositories\Appointment\Exceptions\OverlappingAppointmentException;
use Barber\Repositories\Exceptions\Sort\SortableFieldNotAllowed;
use Barber\Repositories\Appointment\AppointmentRepository as Appointment;
use Barber\Transformers\AppointmentTransformer as AppointmentTransformer;
use Barber\Services\Paginator\Paginator as Paginator;
use Barber\Validators\Appointment\Service\ServiceValidator;
use Barber\Validators\Exceptions\ValidationException;
use Exception;
use \Input;
use \Carbon\Carbon as Carbon;
use Barber\Validators\Appointment\AppointmentValidator as Validator;
use Barber\Repositories\Appointment\Service\ServiceRepository as ServiceRepository;
use Services_Twilio;
use DB;

/**
 * Class AppointmentsController
 * @package Api\V1
 */
class AppointmentsController extends ApiController {

    /**
     * @var Appointment
     */
    private $appointment;

    /**
     * @var AppointmentTransformer
     */
    private $appointmentTransformer;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var ServiceRepository
     */
    private $service;

    /**
     * @var ServiceValidator
     */
    private $serviceValidator;


    /**
     * @param Appointment $appointment
     * @param AppointmentTransformer $appointmentTransformer
     * @param Paginator $paginator
     * @param Validator $validator
     * @param ServiceRepository $service
     * @param ServiceValidator $serviceValidator
     */
    public function __construct(Appointment $appointment, AppointmentTransformer $appointmentTransformer, Paginator $paginator, Validator $validator, ServiceRepository $service, ServiceValidator $serviceValidator)
    {
        $this->appointment             = $appointment;
        $this->appointmentTransformer  = $appointmentTransformer;
        $this->paginator               = $paginator;
        $this->validator               = $validator;
        $this->service                 = $service;
        $this->serviceValidator        = $serviceValidator;
    }


    /**
     *
     */
    public function index()
    {
        $page      = Input::get('page', 1);
        $limit     = Input::get('limit', 10);
        $customer  = Input::get('customer', null);
        // TODO : barber=1,2,3,etc...
        $barber    = Input::get('barber', null);
        $store     = Input::get('store', null);

        // TODO : validar si es timestamp o date_format
        $date_from = Input::get('from', null);
        $date_to   = Input::get('to', null);

        $date_to   = empty($date_from) ? null : $date_to;


        $params    = Input::all();

        // También puede recibir estos parámetros y los válida contra from - to
        $dateStart    = empty($params['start']) ? Carbon::now()->toDateString() : Carbon::createFromTimestamp($params['start'])->toDateString();
        $dateEnd      = empty($params['end'])   ? Carbon::now()->toDateString() : Carbon::createFromTimestamp($params['end'])->toDateString();
        $date         = empty($params['date'])   ? Carbon::now()->toDateString() : Carbon::createFromFormat('Y-m-d', $params['date'])->toDateString();

        if ( ! empty($date_from) and ! empty($date_to))
        {
            $from = $date_from;
            $to   = $date_to;
        }
        else if ( ! empty($dateStart) and  ! empty($dateEnd))
        {
            $from = $dateStart;
            $to   = $dateEnd;
        }
        else // filtro por default
        {
            $from = $date;
            $to   = $date;
        }

        // TODO : agregar ?include=services,etc
        $include   = Input::get('include', null);

        $sortableFieldsAllowed = [
            'start',
            'status',
        ];

        try {
            $sort = build_sortable_fields(Input::get('sort', null), $sortableFieldsAllowed);

            $params = [
                'sort'     => Input::get('sort', null),
                'customer' => $customer,
                'barber'   => $barber,
                'store'    => $store,
                'from'     => $date_from,
                'to'       => $date_to
            ];

            $appointments = $this->appointment->getByPage($page, $limit, $sort, $from, $to, $barber, $store, $customer);
            $pagination   = $this->paginator->paginate($this->appointment->count(), $limit, $params);
        }
        catch(SortableFieldNotAllowed $e)
        {
            return $this->respondBadRequest($e->getMessage());
        }
        catch(SortableFieldInvalid $e)
        {
            return $this->respondBadRequest($e->getMessage());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        /*return $this->respond([
            'pagination' => $pagination,
            'data'       => $this->appointmentTransformer->transformCollection($appointments)
        ]);*/
        // TODO : Fullcalendar no recibe parámetros como los anteriores, el array debe ser directo
        return $this->respond(
            $this->appointmentTransformer->transformCollection($appointments)
        );
    }

    /**
     *
     */
    public function store()
    {
        $data = getApiInput();
        
        try
        {
            $data['store_id']    = empty($data['store']['id'])    ? null : $data['store']['id'];
            $data['barber_id']   = empty($data['barber']['id'])   ? null : $data['barber']['id'];
            $data['customer_id'] = empty($data['customer']['id']) ? null : $data['customer']['id'];

            // TODO : validar que la sucursal pertenezca a la empresa donde esta registrado el cliente, si no, lanzar excepcion
            // TODO : validar que la cita no se solape sobre otra del mismo barbero, misma sucursal
            // TODO: Validar que la cita no sea agendada en días anteriores

            $this->validator->validateForCreate($data);

            // TODO : validar servicios para la cita
            if ( empty($data['services']))
            {
                throw new ValidationException('No hay servicios agregados para la cita', [
                    'No se agregaron servicios para la cita.'
                ]);
            }


            // Validar servicios de la cita
            foreach($data['services'] as $service)
            {
                $service['service_id'] = empty($service['service']['id']) ? null : $service['service']['id'];
                $this->serviceValidator->validateForCreate($service);
            }

            $appointment = $this->appointment->create($data);

            // TODO : Una vez creada la cita, agregar los servicios
            foreach($data['services'] as $service)
            {
                $service['service_id'] = $service['service']['id'];
                
                $this->service->create($appointment->id, $service);
            }

            $appointment = $this->appointmentTransformer->transform($appointment);

            if ( ! empty($data['notify_by_email']))
            {
                \Mail::send('emails.appointments.confirmation', ['appointment' => $appointment], function($message) use ($appointment)
                {
                    $message->to($appointment['customer']['email'], $appointment['title'])->subject('Cita agendada - M&N Gentleman\'s Barber');
                });
            }

//            if ( ! empty($data['notify_by_cellphone']))
//            {
//                $client = new \Services_Twilio(getenv('services.twilio.sid'), getenv('services.twilio.token'));
//
//                $sms_text = 'Cita agendada para el día: ' . \Carbon\Carbon::createFromTimestamp($appointment['start'])->format('d/m/Y G:i A');
//                $sms_text .= " " . getenv('company.name');
//
//                $message = $client->account->sms_messages->create(
//                    getenv('services.twilio.number'), #'+525549998114', // From a Twilio number in your account
//                    $appointment['customer']['cellphone_formatted'], // Text any number
//                    $sms_text
//                );
//            }

        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(ResourceOnCreateException $e)
        {
            return $this->respondInternalError('Error al crear la cita.');
        }
        catch(OverlappingAppointmentException $e)
        {
            return $this->respondInternalError('Ya existe una cita registrada para esta hora.');
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('Error en la aplicación.' . $e->getMessage());
        }

        return $this->respondCreated([
            'data' => $appointment,
        ],
            [
                'location' => route('api.appointments.show', $appointment['id'])
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // TODO : agregar ?include=company,etc
        try
        {
            $appointment = $this->appointment->getById($id);
        }
        catch(ResourceNotFoundException $e)
        {
            return $this->respondNotFound($e->getMessage());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        return $this->respond([
            'data' => $this->appointmentTransformer->transform($appointment)
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
//        TODO: Check
        // return $this->respond([
        //     'data' => null,
        //     'id'    => $id,
        //     'start' =>$_GET[ 'start' ],
        //     'end' =>$_GET[ 'end' ],
        // ]);
        // Chage by Codeman Company
        // Check method PUT
//        $data = getApiInput();
        try
        {
//            $data['barber_id'] = empty($data['barber']['id']) ? null : $data['barber']['id'];
        //     return $this->respond([
        //     'data' => $data['barber_id'],
        // ]);

            // Check: remove for Codeman 
            // $this->validator->validateForUpdate($id, $data);


            /********/

            // TODO : validar que la cita cuando se este moviendo de hora no valide los servicios BUGGGGG
            /*if ( ! empty($data['services']))
            {
                throw new ValidationException('No hay servicios agregados para la cita', [
                    'No se agregaron servicios para la cita.'
                ]);
            }*/


//            if ( ! empty($data['services']))
//            {
//                // Validar servicios de la cita
//                foreach($data['services'] as $service)
//                {
//                    $service['service_id'] = empty($service['service']['id']) ? null : $service['service']['id'];
//                    $this->serviceValidator->validateForUpdate($service['service_id'], $service);
//                }
//            }


//            $appointment = $this->appointment->update($id, $data);

//            $data = [
//                'start' =>  $_GET[ 'start' ],
//                'end'   =>  $_GET[ 'start' ],
//            ];


//            DB::update( "UPDATE appointments SET start = '?', end = '?' WHERE id = 8266 LIMIT 1", $data );

            // Function good
            //die(var_dump($data = getApiInput()));
         
            DB::table( 'appointments' ) -> where( 'id', $id ) -> update( [
                'start' =>  $_GET['start'],
                'end'   =>  $_GET['end'],
                'barber_id'   =>  $_GET[ 'barber_id' ]
            ] );

            DB::statement( 'SET lc_time_names = \'es_VE\';' );
            $data = DB::select( 'SELECT barbers.first_name AS barber, customers.email AS email, customers.first_name AS name, ( SELECT services.name FROM barbershop.services WHERE services.id = ( SELECT appointment_service.service_id FROM barbershop.appointment_service WHERE appointment_service.appointment_id = appointments.id LIMIT 1 ) ) AS service, date_format( appointments.start, \'%W %d de %M de %Y a las %H:%m horas\' ) AS start FROM barbershop.appointments INNER JOIN barbershop.customers ON appointments.customer_id = customers.id INNER JOIN barbershop.barbers ON appointments.barber_id = barbers.id WHERE appointments.id = ?;', [ $id ] );
            $data = $data[ 0 ];

            $data -> start = str_replace( 'De', 'de', ucwords( $data -> start ) );
            $data -> start = str_replace( 'A', 'a', $data -> start );
            $data -> start = str_replace( 'Las', 'las', $data -> start );

            \Mail::send('emails.appointments.modify', [ 'data' => $data ], function( $message ) use ( $data )
            {
                $message -> to( $data -> email, $data -> name ) -> subject( 'Aviso de modificación de cita - M&N Gentleman\'s Barber' );
            });

//            if ( ! empty($data['services'])) {
//                // TODO : Una vez creada la cita, actualizar los servicios
//                $this->service->updateOrCreate($appointment->id, $data['services']);
//            }

            /*************/
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(OverlappingAppointmentException $e)
        {
            return $this->respondInternalError('Ya existe una cita registrada para esta hora.');
        }
        catch(Exception $e)
        {
           
            return $this->respondInternalError('Error en la aplicación.');
        }

        return $this->respond([
//            'data' => $this->appointmentTransformer->transform($appointment),
            'data'      =>  $data,
            'result'    =>  'success',
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        // TODO :  Actualizar cita con estatus de eliminado
        try
        {
            $appointment = $this->appointment->cancel($id);
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('There was an error while canceling the appointment.');
        }

        return $this->respond([
            'data' => $this->appointmentTransformer->transform($appointment),
        ]);
    }

}
