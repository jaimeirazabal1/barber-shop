<?php namespace Barber\Repositories\Group;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/2/15
 * Time: 11:41 PM
 */


/**
 * Interface GroupRepository
 * @package Barber\Repositories\Group
 */
interface GroupRepository {

    /**
     * Obtiene el grupo especificado por su nombre
     *
     * @param $name
     * @return mixed
     */
    public function getByName($name);

}