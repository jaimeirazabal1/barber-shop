<?php namespace App\Services\Hasher;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/26/15
 * Time: 3:49 PM
 */

use \Hashids\Hashids as Hashids;


/**
 * Class HashidsHasher
 * @package App\Services\Hasher
 */
class HashidsHasher implements Hasher {

    /**
     * @var Hashids
     */
    private $hasher;


    /**
     * @param Hashids $hasher
     */
    public function __construct(Hashids $hasher)
    {
        $this->hasher = $hasher;
    }


    /**
     * @param $id
     * @return string
     */
    public function encode($id)
    {
        if ( ! is_numeric($id))
        {
            throw new \InvalidArgumentException;
        }

        return $this->hasher->encode($id);
    }


    /**
     * @param $hash
     * @return array
     */
    public function decode($hash)
    {
        if( empty($hash))
        {
            throw new \InvalidArgumentException;
        }


        $id = $this->hasher->decode($hash);

        return $id[0];
    }
}