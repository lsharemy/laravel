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
| Intervention Image
|--------------------------------------------------------------------------
*/

Route::get('image/small/{src}', function($src)
{
	$img = Image::cache(function($image) use ($src) {
		$image->make('images/'.$src)->resize(100, 100);
	}, 10, true);
	//$img = Image::make('images/'.$src)->resize(100, 100);

	// create response and add encoded image data
	$response = Response::make($img->encode('png'));

	// set content-type
	$response->header('Content-Type', 'image/png');

	// output
	return $response;
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

/*
|--------------------------------------------------------------------------
| Requests & Input
|--------------------------------------------------------------------------
*/

// Retrieving An Input Value
Route::get('basicInput1', function()
{
	return Input::get('name');
});

// Retrieving A Default Value If The Input Value Is Absent
Route::get('basicInput1', function()
{
	return Input::get('name', 'Sally');
});

// Determining If An Input Value Is Present
Route::get('basicInput2', function()
{
	if (Input::has('name'))
	{
		return "has name";
	}
	else
	{
		return "no name";
	}
});

// Getting All Input For The Request
Route::get('basicInput3', function()
{
	return Input::all();
});

// Getting Only Some Of The Request Input
Route::get('basicInput4', function()
{
	return Input::only('username', 'password');
});
Route::get('basicInput5', function()
{
	return Input::except('credit_card');
});

// Retrieving A Cookie Value
Route::get('cookies1', function()
{
	return Cookie::get('name');
});

// Attaching A New Cookie To A Response
Route::get('cookies2', function()
{
	$response = Response::make('Hello World');

	$response->withCookie(Cookie::make('name', 'value', 1));

	return $response;
});

// Queueing A Cookie For The Next Response
Route::get('cookies3', function()
{
	Cookie::queue("abc", "123", 1);
	return "abc";
});

// Old Input
Route::get('oldInput', function()
{
	return Redirect::to('oldInput2')->withInput();
});

Route::get('oldInput2', function()
{
	return Session::all();
});

// Files
Route::post('fileUpload', function()
{
	if (Input::hasFile('fileToUpload'))
	{
		$file = Input::file('fileToUpload');
		return $file->getMimeType()."|".$file->getRealPath()."|".$file->getClientOriginalName();
	}
});

// Request Information
Route::get('requestInformation', function()
{
	return Request::path()."|".Request::url()."|".Request::segment(1)."|".Request::format();
});

/*
|--------------------------------------------------------------------------
| Views & Responses
|--------------------------------------------------------------------------
*/

// Creating Custom Responses
Route::get('customResponses', function()
{
	$response = Response::make("abc", 200);

	$response->header('Content-Type', "text/html");

	return $response;
});

// Redirects
Route::get('Redirects', function()
{
	return Redirect::to('/');
});

// Views
Route::get('subView', function()
{
	return View::make('hello')->nest('child', 'child.view');
});

// View Composers
View::composer('hello', function($view)
{
	$view->with('count', User::count());
});

// Special Responses
Route::get('JSONResponses', function()
{
	return Response::json(array('name' => 'Steve', 'state' => 'CA'));
});

// Response Macros
// skip

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

// Basic Controllers
Route::get('basicControllers/{id}', 'UserController@showProfile');

// Controller Filters
// skip
// Implicit Controllers
// skip
// RESTful Resource Controllers
// skip
// Handling Missing Methods
// skip


Route::get('sessionAll', function()
{
	return Session::all();
});
