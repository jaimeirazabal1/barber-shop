<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
    if (Auth::guest())
    {
        if (Request::ajax())
        {
            return Response::make('Unauthorized', 401);
        }
        else
        {
            return Redirect::guest('login');
        }
    }
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


/*
|--------------------------------------------------------------------------
| Custom filters
|--------------------------------------------------------------------------
|
|
*/


/*
|--------------------------------------------------------------------------
| FILTERS FOR ACCOUNTS
|--------------------------------------------------------------------------
|
*/
/*
Route::filter('accounts.index', function() # ACCOUNTS - LIST
{
    ! Sentry::getUser()->hasAnyAccess(array('ventas', 'ingresos', 'admin')) and Redirect::route('sessions.forbidden')->send();
});

Route::filter('accounts.create', function() # ACCOUNT - CREATE
{
    ! Sentry::getUser()->hasAnyAccess(array('ventas', 'ingresos', 'admin')) and Redirect::route('sessions.forbidden')->send();
});

Route::filter('accounts.update', function() # ACCOUNT - UPDATE
{
    ! Sentry::getUser()->hasAnyAccess(array('ventas', 'ingresos', 'admin')) and Redirect::route('sessions.forbidden')->send();
});

Route::filter('accounts.show', function() # ACCOUNT - UPDATE
{
    ! Sentry::getUser()->hasAnyAccess(array('ventas', 'ingresos', 'admin')) and Redirect::route('sessions.forbidden')->send();
});
*/


/*
|--------------------------------------------------------------------------
| FILTERS FOR USERS
|--------------------------------------------------------------------------
|
*/

/***************** APPOINTMENTS ***************/

Route::filter('appointments.all', function() # APPOINTMENTS
{
    ! Sentry::getUser()->hasAnyAccess(array('admin', 'company', 'store')) and Redirect::route('sessions.forbidden', Session::get('subdomain'))->send();
});

/***************** STORES ***************/

Route::filter('stores.list', function() # STORES
{
    ! Sentry::getUser()->hasAnyAccess(array('admin', 'company')) and Redirect::route('sessions.forbidden', Session::get('subdomain'))->send();
});

Route::filter('stores.create', function() # STORES
{
    ! Sentry::getUser()->hasAnyAccess(array('admin', 'company')) and Redirect::route('sessions.forbidden', Session::get('subdomain'))->send();
});

Route::filter('stores.update', function() # STORES
{
    ! Sentry::getUser()->hasAnyAccess(array('admin', 'company', 'store')) and Redirect::route('sessions.forbidden', Session::get('subdomain'))->send();
});

/***************** SALES ***************/

Route::filter('sales.list', function() # STORES
{
    ! Sentry::getUser()->hasAnyAccess(array('admin', 'company', 'store')) and Redirect::route('sessions.forbidden', Session::get('subdomain'))->send();
});

Route::filter('sales.create', function() # STORES
{
    ! Sentry::getUser()->hasAnyAccess(array('admin', 'company', 'store')) and Redirect::route('sessions.forbidden', Session::get('subdomain'))->send();
});

Route::filter('sales.update', function() # STORES
{
    ! Sentry::getUser()->hasAnyAccess(array('admin', 'company', 'store')) and Redirect::route('sessions.forbidden', Session::get('subdomain'))->send();
});


Route::filter('auth.admin.sentry', function()
{
    if ( ! Sentry::check())
    {
        if (Request::ajax())
        {
            return Response::make('Unauthorized', 401);
        }
        else
        {
            return Redirect::route('admin.sessions.create');
        }
    }
});

Route::filter('auth.sentry', function()
{
    if ( ! Sentry::check())
    {
        if (Request::ajax())
        {
            return Response::make('Unauthorized', 401);
        }
        else
        {
            return Redirect::route('sessions.create', Session::get('subdomain'));
        }
    }
});


Route::filter('getSubdomain', function($route, $request)
{
    $host = $request->getHost();
    $parts = explode('.', $host);
    $subdomain = $parts[0];

    if ( ! $company = Company::whereSlug($subdomain)->first())
    {
        die('Not found ' . $subdomain);
    }

    Session::put('subdomain', $subdomain);

});
