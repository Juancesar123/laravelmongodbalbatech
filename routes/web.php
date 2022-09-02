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
$router->post('/login', 'AuthController@login' );
$router->post('/register', 'AuthController@register' );

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('/logout', 'AuthController@logout' );
// Tag section
    $router->get('/tag', 'TagController@index' );
    $router->post('/tag', 'TagController@store' );
    $router->put('/tag/{id}', 'TagController@update' );
    $router->delete('/tag/{id}', 'TagController@destroy' );
// ------------------- end Tag section ------------
// category section
$router->get('/category', 'CategoryController@index' );
$router->post('/category', 'CategoryController@store' );
$router->put('/category/{id}', 'CategoryController@update' );
$router->delete('/category/{id}', 'CategoryController@destroy' );
// ------------------- end category section ------------
   
});
$router->get('/firebase', 'FirebaseController@index' );
$router->get('/get-filterdata','CurlApiController@index');