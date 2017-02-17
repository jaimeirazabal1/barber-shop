<?php namespace App\Providers;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/26/15
 * Time: 3:51 PM
 */

class ServicesServiceProvider extends \Illuminate\Support\ServiceProvider {

    /**
     *
     */
    public function register()
    {
        $this->app->bind('Barber\Services\Paginator\Paginator', 'Barber\Services\Paginator\LaravelPaginator');
    }
}