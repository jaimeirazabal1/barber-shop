<?php
/**
 * Created by Netcommerce.mx
 * User: diego
 * Date: 12/08/15
 * Time: 01:07 PM
 */

class StoreCheckinController extends BaseController {

    /**
     * @param $company
     * @param $store
     * @return mixed
     */
    public function create($company, $store)
    {
        $companyo = Company::whereSlug($company)->first();
        $store    = Store::whereSlug($store)->first();

        setlocale(LC_TIME, 'es_MX');
        $dt = \Carbon\Carbon::now();
        $datefull = $dt->formatLocalized('%d / %B / %Y');          // Wednesday 21 May 1975
        $day = $dt->formatLocalized('%A');          // Wednesday 21 May 1975
        $type_checkins = [
            'check_in' => 'Entrada',
            'mealtime_start' => 'Inicio - Hora de comida',
            'mealtime_over' => 'Fin - Hora de comida',
            'check_out' => 'Salida'
        ];

        return View::make('store-checkin.create', compact('companyo', 'store', 'datefull', 'day', 'type_checkins'));
    }

}