<?php

$router->get('/', function () use ($router) {
    echo 'Hello World';
});

$router->get('categories', 'CategoryController@index');
$router->post('categories', 'CategoryController@store');
$router->put('categories/{id}', 'CategoryController@update');
$router->delete('categories/{id}', 'CategoryController@destroy');