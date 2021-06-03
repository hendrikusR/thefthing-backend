<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'customer'], function () use ($router) {
    $router->get('/', ['as' => 'customer', 'uses' => 'CustomerController@index']);
    $router->get('/edit/{id}', ['as' => 'customer', 'uses' => 'CustomerController@edit']);
    $router->post('/update/{id}', ['as' => 'customer', 'uses' => 'CustomerController@update']);
    $router->post('/store', ['as' => 'customer-store', 'uses' => 'CustomerController@store']);
    $router->post('/{id}/delete', ['as' => 'customer-delete', 'uses' => 'CustomerController@destroy']);
});

