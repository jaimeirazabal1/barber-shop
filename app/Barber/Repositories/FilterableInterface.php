<?php namespace Barber\Repositories;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/1/15
 * Time: 4:38 PM
 */


/**
 * Interface FilterableInterface
 * @package Barber\Repositories
 */
interface FilterableInterface {

    /**
     * Aplica filtro deseado en la consulta
     *
     * @param $filter
     * @return mixed
     */
    public function filter($filter);
}