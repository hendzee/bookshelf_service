<?php

$router->get('/', function () use ($router) {
    echo 'Hello World';
});

/** Users route */
$router->get('users', 'UserController@index');
$router->get('users/{id}', 'UserController@show');
$router->post('users', 'UserController@store');
$router->put('users/{id}', 'UserController@update');
$router->delete('users/{id}', 'UserController@destroy');

/** Categories route */
$router->get('categories', 'CategoryController@index');
$router->post('categories', 'CategoryController@store');
$router->put('categories/{id}', 'CategoryController@update');
$router->delete('categories/{id}', 'CategoryController@destroy');

/** Descriptions(Abouts) route */
$router->get('descriptions/{id}', 'DescriptionController@show');
$router->put('descriptions/{id}', 'DescriptionController@update');