<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('users', function()
{
	$users = User::all();

	return View::make('users')->with('users', $users);
});

/*
|--------------------------------------------------------------------------
| Routing
|--------------------------------------------------------------------------
*/

// Basic GET Route
Route::get('basicGet', function()
{
	return 'Hello World';
});

// Basic POST Route
Route::post('basicPost', function()
{
	return 'Hello World';
});

// Registering A Route For Multiple Verbs
Route::match(array('GET', 'POST'), 'multipleVerbs', function()
{
	return 'Hello World';
});

// Registering A Route Responding To Any HTTP Verb
Route::any('anyVerb', function()
{
	return 'Hello World';
});

// Forcing A Route To Be Served Over HTTPS
Route::get('https', array('https', function()
{
	return 'Must be over HTTPS';
}));

// Often, you will need to generate URLs to your routes, you may do so using the URL::to method:
Route::any('urlTo', function()
{
	return URL::to('urlTo');
});

// Route Parameters
Route::get('routeParams/{id}', function($id)
{
	return 'routeParams '.$id;
});

// Optional Route Parameters
Route::get('optionalParams/{name?}', function($name = null)
{
	return 'optionalParams '.$name;
});

// Optional Route Parameters With Defaults
Route::get('optionalParamsWithDefaults/{name?}', function($name = 'John')
{
	return 'optionalParamsWithDefaults '.$name;
});

// Regular Expression Route Constraints
Route::get('regexName/{name}', function($name)
{
	return 'regexName '.$name;
})
->where('name', '[A-Za-z]+');

Route::get('regexID/{id}', function($id)
{
	return 'regexID '.$id;
})
->where('id', '[0-9]+');

// Passing An Array Of Wheres
Route::get('arrayOfWheres/{id}/{name}', function($id, $name)
{
	return 'ID '.$id.' Name '.$name;
})
->where(array('id' => '[0-9]+', 'name' => '[a-z]+'));

// Defining Global Patterns
Route::pattern('id', '[0-9]+');

Route::get('globelPatterns/{id}', function($id)
{
	return 'globelPatterns '.$id;
});

// Accessing A Route Parameter Value
Route::get('AccessRouteParams/{id}', array('before' => 'AccessRouteParams', function($id)
{
	return 'routeParams '.$id;
}));

// Attaching A Filter To A Route
Route::get('filterRoute', array('before' => 'old', function()
{
	return 'You are over 200 years old!';
}));

// Attaching A Filter To A Controller Action
Route::get('filterToController', array('before' => 'old', 'uses' => 'HomeController@showWelcome'));

// Attaching Multiple Filters To A Route
Route::get('multipleFilterToRoute', array('before' => 'auth|old', function()
{
	return 'You are authenticated and over 200 years old!';
}));

// Attaching Multiple Filters Via Array
Route::get('multipleFilterViaArray', array('before' => array('auth', 'old'), function()
{
	return 'You are authenticated and over 200 years old!';
}));

// Specifying Filter Parameters
Route::get('filterParams', array('before' => 'age:200', function()
{
	return 'Hello World';
}));

// After Filter
Route::get('filterParamsResponse', array('after' => 'logAfter', function()
{
	return 'Hello World';
}));

// Pattern Based Filters
Route::get('patternBasedFilters/{id}', function()
{
	return 'Hello World';
});

// Named Routes
// skip

//Route Groups
Route::group(array('before' => 'auth'), function()
{
	Route::get('routeGroups/1', function()
	{
		return "1";
	});

	Route::get('routeGroups/2', function()
	{
		return "2";
	});
});

// namespace, good!
Route::group(array('namespace' => 'Admin'), function()
{
	//
});

// Sub-Domain Routing
// skip

// Route Prefixing
Route::group(array('prefix' => 'routePrefixing'), function()
{
	Route::get('user', function()
	{
		return "routePrefixing user";
	});
});

// Route Model Binding
Route::model('user', 'User');
Route::get('profile/{user}', function(User $user)
{
	return $user;
});
Route::bind('username', function($value, $route)
{
	return User::where('name', $value)->first();
});
// http://localhost:8000/username/Li,%20Muyu
Route::get('username/{username}', function(User $user)
{
	return $user;
});
