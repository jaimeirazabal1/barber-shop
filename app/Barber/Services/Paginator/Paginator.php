<?php namespace Barber\Services\Paginator;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/31/15
 * Time: 9:28 AM
 */


/**
 * Interface Paginator
 * @package Barber\Services\Paginator
 */
interface Paginator {

    /**
     * Devuelve los datos paginados
     *
     **
     * @param $totalItems
     * @param $limit
     * @param array $params
     * @return mixed
     */
    public function paginate($totalItems, $limit, array $params = array());


}