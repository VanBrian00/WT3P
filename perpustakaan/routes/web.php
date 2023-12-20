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

//Get
$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/buku/output', 'BukuController@get');
$router->get('/buku/outputx', 'BukuController@getx');
$router->get('/pustakawan/output', 'PustakawanController@get');

//Post
$router->post('/buku/input', 'BukuController@store');
$router->post('/pustakawan/input', 'PustakawanController@store');

//Update/ Put
$router->post('/buku/update', 'BukuController@update');
$router->post('/pustakawan/update', 'PustakawanController@update');

//Delete
$router->post('/buku/delete', 'BukuController@destroy');
$router->post('/pustakawan/delete', 'PustakawanController@destroy');

