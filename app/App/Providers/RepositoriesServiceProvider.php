<?php namespace App\Providers;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/26/15
 * Time: 3:51 PM
 */


use Illuminate\Support\ServiceProvider;


/**
 * Class RepositoriesServiceProvider
 * @package App\Providers
 */
class RepositoriesServiceProvider extends ServiceProvider {

    /**
     *
     */
    public function register()
    {
        $this->app->bind('Barber\Repositories\User\UserRepository', 'Barber\Repositories\User\EloquentUserRepository');
        $this->app->bind('Barber\Repositories\Group\GroupRepository', 'Barber\Repositories\User\EloquentGroupRepository');
        $this->app->bind('Barber\Repositories\Company\CompanyRepository', 'Barber\Repositories\Company\EloquentCompanyRepository');
        $this->app->bind('Barber\Repositories\Store\StoreRepository', 'Barber\Repositories\Store\EloquentStoreRepository');
        $this->app->bind('Barber\Repositories\Barber\BarberRepository', 'Barber\Repositories\Barber\EloquentBarberRepository');
        $this->app->bind('Barber\Repositories\Service\ServiceRepository', 'Barber\Repositories\Service\EloquentServiceRepository');
        $this->app->bind('Barber\Repositories\Product\ProductRepository', 'Barber\Repositories\Product\EloquentProductRepository');
        $this->app->bind('Barber\Repositories\Customer\CustomerRepository', 'Barber\Repositories\Customer\EloquentCustomerRepository');
        $this->app->bind('Barber\Repositories\Customer\Service\ServiceRepository', 'Barber\Repositories\Customer\Service\EloquentServiceRepository');
        $this->app->bind('Barber\Repositories\Checkin\CheckinRepository', 'Barber\Repositories\Checkin\EloquentCheckinRepository');
        $this->app->bind('Barber\Repositories\Appointment\AppointmentRepository', 'Barber\Repositories\Appointment\EloquentAppointmentRepository');
        $this->app->bind('Barber\Repositories\Appointment\Service\ServiceRepository', 'Barber\Repositories\Appointment\Service\EloquentServiceRepository');
    }
}