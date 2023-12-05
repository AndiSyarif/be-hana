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

//route auth
$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
$router->get('/user', 'AuthController@user');

//route point
$router->get('/index', 'PointController@index');
$router->post('/store', 'PointController@store');
$router->get('/show/{user_id}', 'PointController@show');
$router->patch('/update/{user_id}', 'PointController@update');
$router->delete('/destroy/{user_id}', 'PointController@destroy');


