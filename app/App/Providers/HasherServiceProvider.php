<?php namespace App\Providers;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/26/15
 * Time: 3:51 PM
 */

class HasherServiceProvider extends \Illuminate\Support\ServiceProvider {

    /**
     *
     */
    public function register()
    {
        $this->app->bind('App\Services\Hasher\Hasher', 'App\Services\Hasher\HashidsHasher');
    }
}