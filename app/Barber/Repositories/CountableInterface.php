<?php namespace Barber\Repositories;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/1/15
 * Time: 2:46 PM
 */


/**
 * Interface CountableInterface
 * @package Barber\Repositories
 */
interface CountableInterface {

    /**
     * Obtiene el número de registros totales
     *
     * @return mixed
     */
    public function count();

}