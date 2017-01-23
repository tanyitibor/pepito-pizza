<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', [
    'uses'  => 'HomeController@index',
    'as'    => 'home',
]);

Route::get('/contact', [
	'uses'	=> 'ContactController@index',
	'as'	=> 'contact',
]);

Route::resource('pizzas', 'PizzaController', [
    'only' => [
        'index'
    ]
]);

Route::resource('orders', 'OrderController', [
	'only' => [
		'show', 'store'
	]
]);

Route::resource('address', 'AddressController', [
	'only'	=> [
		'store', 'update', 'destroy'
	]
]);

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

Route::get('profile', [
	'uses'	=> 'ProfileController@index',
	'as'	=> 'profile.index',
]);
Route::post('profile', 'ProfileController@update');

Route::group([
	'prefix'	=> 'dashboard',
	'namespace'	=> 'Dashboard',
	'as'		=> 'dashboard.',
	'middleware'=> ['employee'],
], function() {
	Route::get('/', function() {
		return redirect()->route('dashboard.orders.index');
	});

	Route::resource('users', 'UserController', [
		'only' => [
			'index', 'update'
		]
	]);	

	Route::resource('orders', 'OrderController', [
		'only' => [
			'index', 'update'
		]
	]);

	Route::resource('pizzas', 'PizzaController', [
		'only' => [
			'index', 'create', 'store', 'edit', 'update', 'destroy'
		]
	]);

	Route::resource('toppings', 'ToppingController', [
		'only'	=> [
			'index', 'store', 'update', 'destroy'
		]
	]);
});