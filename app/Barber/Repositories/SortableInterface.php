<?php namespace Barber\Repositories;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/1/15
 * Time: 2:45 PM
 */


/**
 * Interface SortableInterface
 * @package Barber\Repositories
 */
interface SortableInterface {

    /**
     * Crea el ordenamiento de los campos
     *
     * @param array $fields
     * @return mixed
     */
    public function sort(array $fields);

}