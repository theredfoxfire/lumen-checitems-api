<?php

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

$router->group(['prefix' => 'api/'], function ($router) {
    $router->post('login/', 'UsersController@authenticate');
    $router->post('register/', 'UsersController@register');

    $router->group(['prefix' => 'items/'], function ($router) {
        $router->get('/', 'ItemsController@index');
        $router->get('completed/', 'ItemsController@completed');
        $router->get('incompleted/', 'ItemsController@incompleted');
        $router->get('{id}', 'ItemsController@show');
        $router->post('/', 'ItemsController@store');
        $router->put('{id}', 'ItemsController@update');
        $router->delete('{id}', 'ItemsController@destroy');
    });
    $router->group(['prefix' => 'templates/'], function ($router) {
        $router->get('/', 'TemplatesController@index');
        $router->get('{id}', 'TemplatesController@show');
        $router->post('/', 'TemplatesController@store');
        $router->put('{id}', 'TemplatesController@update');
        $router->delete('{id}', 'TemplatesController@destroy');
    });
    $router->group(['prefix' => 'checklists/'], function ($router) {
        $router->get('/', 'ChecklistsController@index');
        $router->get('{id}', 'ChecklistsController@show');
        $router->post('/', 'ChecklistsController@store');
        $router->put('{id}', 'ChecklistsController@update');
        $router->delete('{id}', 'ChecklistsController@destroy');
    });
});
