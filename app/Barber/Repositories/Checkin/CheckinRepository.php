<?php namespace Barber\Repositories\Checkin;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 7/30/15
     * Time: 12:10 PM
     */


/**
 * Interface CheckinRepository
 * @package Barber\Repositories\Checkin
 */
interface CheckinRepository {

    /**
     * @param $checkin_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($checkin_id);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);


    /**
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param null $from
     * @param null $to
     * @param null $barber
     * @param null $store
     * @return mixed
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $from = null, $to = null, $barber = null, $store = null);

}


