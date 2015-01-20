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
		return Redirect::guest('login');
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
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
*/

// Accessing A Route Parameter Value
Route::filter('AccessRouteParams', function()
{
	if (Route::input('id') == 1)
	{
		return "1!";
	}
});

// Defining A Route Filter
Route::filter('old', function()
{
	if (Input::get('age') < 200)
	{
		return "< 200";
	}
});

// Specifying Filter Parameters
Route::filter('age', function($route, $request, $value)
{
	if (Input::get('age') == $value)
	{
		return "200!";
	}
});

// After Filter
Route::filter('logAfter', function($route, $request, $response)
{
	var_dump($response);
});

// Pattern Based Filters
Route::filter('patternBasedFilters', function()
{
	return "Pattern Based Filters";
});

Route::when('patternBasedFilters/*', 'patternBasedFilters');

// Filter Classes
// skip
