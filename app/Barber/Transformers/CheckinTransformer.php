<?php namespace Barber\Transformers;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:18 PM
     */

/**
 * Class CheckinTransformer
 * @package Barber\Transformers
 */
class CheckinTransformer extends Transformer {


    /**
     * @param $checkin
     * @return array
     */
    public function transform($checkin)
    {
        return [
            'id'         => $checkin->id,
            'checkin'    => $checkin->checkin,
            'lat'        => $checkin->lat,
            'lng'        => $checkin->lng,
            'status'     => $checkin->status,
            // TODO: Validar información publica de Barberos y otros recursos, no todos los datos son visibles para todos, puede ser dependiendo del role que tenga
            'barber'     => [
                'first_name' => $checkin->barber->first_name,
                'last_name' => $checkin->barber->last_name,
            ]
            #Store
            #Barber
        ];
    }

}