<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('create', 'AuthController@register');
    Route::get('logout', 'AuthController@logout');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });
});

//Route::get('categories', 'CategoriesController@index');
//Route::get('categories/{slug}', 'CategoriesController@show');
Route::resource('categories', 'CategoriesController', ['only' => ['index', 'show'] ]);

//Route::get('products', 'ProductsController@index');
//Route::get('products/{id}', 'ProductsController@show');
Route::resource('products', 'ProductsController', ['only' => ['index', 'show'] ]);
Route::post('products/search', 'ProductsController@search');

Route::get('payment/complete', 'PaymentController@complete');
Route::get('payment/cancel', 'PaymentController@cancel');
Route::post('payment/ipn', 'PaymentController@ipn');
Route::get('payment/{hash}', 'PaymentController@create');

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['middleware' => 'privileges:1'], function () {
        Route::get('orders/all', 'OrdersController@all');

        //Route::post('categories', 'CategoriesController@store');
        //Route::put('categories/{id}', 'CategoriesController@update');
        //Route::delete('categories/{id}', 'CategoriesController@destroy');
        Route::resource('categories', 'CategoriesController', ['only' => ['store', 'update', 'destroy'] ]);

        //Route::post('products', 'ProductsController@store');
        //Route::put('products/{id}', 'ProductsController@update');
        //Route::delete('products/{id}', 'ProductsController@destroy');
        Route::resource('products', 'ProductsController', ['only' => ['store', 'update', 'destroy'] ]);

    });

    //Route::get('orders', 'OrdersController@index');
    //Route::get('orders/{hash}', 'OrdersController@show');
    //Route::post('orders', 'OrdersController@store');
    Route::resource('orders', 'OrdersController', ['only' => ['index', 'show', 'store', 'update'] ]);
});