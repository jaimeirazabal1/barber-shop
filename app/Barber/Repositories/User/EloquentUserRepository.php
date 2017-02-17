<?php namespace Barber\Repositories\User;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/30/15
 * Time: 12:11 PM
 */

use Barber\Repositories\Exceptions\ResourceNotFoundException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Exception;
use \Sentry as Sentry;
use \Barber\Repositories\CountableInterface;
use \Barber\Repositories\SortableInterface;
use \Barber\Repositories\FilterableInterface;
use \DB;
use \User;

/**
 * Class EloquentUserRepository
 * @package Barber\Repositories\User
 */
class EloquentUserRepository  implements UserRepository, CountableInterface, SortableInterface, FilterableInterface {

    /**
     * @var User
     */
    protected $user;

    /**
     * @var
     */
    protected $query;

    /**
     * @var
     */
    protected $count;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $user_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($user_id)
    {
        try
        {
            $user = Sentry::findUserById($user_id);
        }
        catch(UserNotFoundException $e)
        {
            throw new ResourceNotFoundException("The user with the ID: {$user_id} does not exists.");
        }

        return $user;
    }

    /**
     * Crea un usuario
     *
     * @param array $data
     * @return mixed|void
     * @throws ResourceNotFoundException
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try
        {
            $user = Sentry::createUser($data);

            $groupName = empty($data['role']) ? 'Cliente' : $data['role'];

            $this->addToGroup($user, $groupName);
        }
        catch(GroupNotFoundException $e)
        {
            DB::rollback();
            throw new ResourceNotFoundException('There was an error while creating the user.');
        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceNotFoundException('There was an error while creating the user.');
        }

        DB::commit();
        return $user;
    }

    /**
     * Actualiza la información del Usuario
     *
     * @param $user_id
     * @param array $data
     * @return mixed|void
     * @throws Exception
     */
    public function update($user_id, array $data)
    {
        $user = $this->getById($user_id);

        $user->email = empty($data['email']) ? $user->email : $data['email'];
        $user->first_name = empty($data['first_name']) ? $user->first_name : $data['first_name'];
        $user->last_name = empty($data['last_name']) ? $user->last_name : $data['last_name'];
        $user->activated = empty($data['activated']) ? $user->activated : $data['activated'];

        if ( ! empty($data['password']))
        {
            $user->password = $data['password'];
        }

        $user->save();

        return $user;
    }

    /**
     * Obtiene todos los Usuarios
     *
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param array $filter
     * @return mixed|void
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $filter = null)
    {
        $this->query = $this->user;

        # Aplica el filtro de búsqueda
        if ( ! empty($filter))
        {
            $this->query = $this->filter($filter);
        }

        # Cuenta los registros de la consulta
        $this->count = $this->query->count();

        # Toma los registros seleccionados
        $this->query = $this->query->skip($limit * ($page - 1))->take($limit);

        # Aplica el ordenamiento de columnas
        if ( ! empty($sort))
        {
            $this->query = $this->sort($sort);
        }

        # Obtiene los registros
        $this->query = $this->query->get();

        # Retorna los registros en forma de arreglo de objetos
        return $this->query->all();
    }

    /**
     * Obtiene el número de registros totales
     *
     * @return mixed
     */
    public function count()
    {
        return $this->count;
    }


    /**
     * Crea el ordenamiento de los campos
     *
     * @param array $fields
     * @return mixed
     */
    public function sort(array $fields)
    {
        foreach($fields as $field)
        {
            $this->query = $this->query->orderBy($field['field'], $field['order']);
        }

        return $this->query;
    }

    /**
     * Aplica filtro deseado en la consulta
     *
     * @param $filter
     * @return mixed
     */
    public function filter($filter)
    {
        $this->query = $this->user->filter($filter);

        return $this->query;
    }


    /**
     * Agrega al usuario al grupo especificado
     *
     * @param $user
     * @param $groupName
     * @return bool
     * @throws ResourceNotFoundException
     */
    protected function addToGroup($user, $groupName = 'Cliente')
    {
        $group = Sentry::findGroupByName($groupName);

        $user->addGroup($group);
    }

}