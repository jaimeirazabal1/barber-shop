<?php namespace App\Providers;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/26/15
 * Time: 3:51 PM
 */

class ValidatorsServiceProvider extends \Illuminate\Support\ServiceProvider {

    /**
     *
     */
    public function register()
    {
        $this->app->bind('Barber\Validators\User\UserValidator', 'Barber\Validators\User\LaracastsUserValidator');
        $this->app->bind('Barber\Validators\Company\CompanyValidator', 'Barber\Validators\Company\LaracastsCompanyValidator');
        $this->app->bind('Barber\Validators\Store\StoreValidator', 'Barber\Validators\Store\LaracastsStoreValidator');
        $this->app->bind('Barber\Validators\Barber\BarberValidator', 'Barber\Validators\Barber\LaracastsBarberValidator');
        $this->app->bind('Barber\Validators\Service\ServiceValidator', 'Barber\Validators\Service\LaracastsServiceValidator');
        $this->app->bind('Barber\Validators\Product\ProductValidator', 'Barber\Validators\Product\LaracastsProductValidator');
        $this->app->bind('Barber\Validators\Customer\CustomerValidator', 'Barber\Validators\Customer\LaracastsCustomerValidator');
        $this->app->bind('Barber\Validators\Customer\Service\ServiceValidator', 'Barber\Validators\Customer\Service\LaracastsServiceValidator');
        $this->app->bind('Barber\Validators\Checkin\CheckinValidator', 'Barber\Validators\Checkin\LaracastsCheckinValidator');
        $this->app->bind('Barber\Validators\Appointment\AppointmentValidator', 'Barber\Validators\Appointment\LaracastsAppointmentValidator');
        $this->app->bind('Barber\Validators\Appointment\Service\ServiceValidator', 'Barber\Validators\Appointment\Service\LaracastsServiceValidator');
    }
}