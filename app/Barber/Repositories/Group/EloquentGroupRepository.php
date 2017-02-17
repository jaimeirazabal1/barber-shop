<?php namespace Barber\Repositories\Group;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 8/2/15
 * Time: 11:42 PM
 */


use Barber\Repositories\Exceptions\ResourceNotFoundException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use \Sentry;

class EloquentGroupRepository implements GroupRepository {

    /**
     * Obtiene el grupo especificado por su nombre
     *
     * @param $name
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getByName($name)
    {
        try
        {
            $group = Sentry::findGroupByName($name);
        }
        catch(GroupNotFoundException $e)
        {
            throw new ResourceNotFoundException('The Group has not been found.');
        }

        return $group;
    }
}