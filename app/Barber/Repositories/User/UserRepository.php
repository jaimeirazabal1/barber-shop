<?php namespace Barber\Repositories\User;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/30/15
 * Time: 12:10 PM
 */


/**
 * Interface UserRepository
 * @package Barber\Repositories\User
 */
interface UserRepository {

    /**
     * @param $user_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($user_id);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $user_id
     * @param array $data
     * @return mixed
     */
    public function update($user_id, array $data);

    /**
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param array $filter
     * @return mixed
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $filter = null);

}


