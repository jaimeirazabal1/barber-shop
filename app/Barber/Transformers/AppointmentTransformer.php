<?php namespace Barber\Transformers;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:18 PM
     */
use Barber\Repositories\Barber\BarberRepository;

// TODO : Averiguar la mejor manera para incluir las relaciones en los modelos

/**
 * Class AppointmentTransformer
 * @package Barber\Transformers
 */
class AppointmentTransformer extends Transformer {


    /**
     * @var
     */
    protected $barber;

    /*protected $includes = [
        'barber',
        'store',
        'customer'
    ];*/


    /**
     * @param \Barber\Repositories\Barber\BarberRepository $barber
     */
    public function __construct(BarberRepository $barber)
    {
        $this->barber = $barber;
    }

    /**
     * @param $appointment
     * @return array
     */
    public function transform($appointment)
    {
        $barber     = $appointment->barber;
        $resourceId = empty($barber) ? 'pending' : ((string) $appointment->barber_id);
        $customer   = $appointment->customer;
        $editable   = true;

        switch($appointment->status)
        {
            case 'completed':
                $editable = false;
                break;
            case 'process':
                $editable = false;
                break;
            default:
                $editable = true;
                break;

        }

        // TODO: inyectar appointment para evitar código duplicado
        return [
            'id'         => $appointment->id,
            'title'      => ($customer->first_name . ' ' . $customer->last_name), // TODO : ver manera de obtener relación con customer
            'start'      => $appointment->start->timestamp,
            'end'        => $appointment->end->timestamp,
            'status'     => $appointment->status,
            'status_text'=> getAppointmentStatus($appointment->status),
            'allDay'     => false,
            'services'   => $appointment->services,
            #'disableResizing' => true,
            'resourceId' => $resourceId,
            'customer'   => [
                'first_name' => $customer->first_name,
                'last_name'  => $customer->last_name,
                'aka'        => $customer->aka,
                'email'      => $customer->email,
                'phone'      => $customer->phone,
                'cellphone'  => $customer->cellphone,
                'cellphone_formatted'  => $customer->cellphone_formatted,
            ],
            'className' =>  ['event', ($appointment->status . '-event')],
            'editable' => $editable
        ];
    }



    /**
     * Include Barber
     *
     * @return Barber
     */
    /*public function includeBarber(Book $book)
    {
        $author = $book->author;

        return $this->item($author, new AuthorTransformer);
    }*/

}