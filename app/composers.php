<?php

// TODO : crear clases de composers para inyectar correctamente las interfaces, se instacion provisionalmente la implementacion de la interfaz
$company = App::make('\Barber\Repositories\Company\EloquentCompanyRepository');
$store   = App::make('\Barber\Repositories\Store\EloquentStoreRepository');

$user = Session::get('user', null);


View::composer([
    'admin.*',
    'appointments.*',
    'barbers.*',
    'cashouts.*',
    'category_products.*',
    'category_services.*',
    'commissions.*',
    'companies.*',
    'customers.*',
    'dashboard.*',
    'layouts.*',
    'partials.*',
    'payroll.*',
    'products.*',
    'sales.*',
    'services.*',
    'sessions.*',
    'store-checkin.*',
    'stores.*',
    'suppliers.*',
    'tag_products.*',
    'tag_services.*',
    'users.*',
    'reports.*'
], function($view) use ($store, $company, $user)
{
    $composerCompany = \Session::get('subdomain');

    $company = $company->getBySlug($composerCompany);

    $composerStores  = $store->getAll($company->id);

    $view->with('company', $composerCompany)
         ->with('composer_stores', $composerStores)
         ->with('composer_user', $user)
         ->with('composer_company', $company);
});