<?php
/** Login user */
$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');

/** Users route */
$router->get('users', ['middleware' => ['auth:api'], 'uses' => 'UserController@index']);
$router->get('users/{id}', ['middleware' => ['auth:api'], 'uses' => 'UserController@show']);
$router->post('users', ['middleware' => ['auth:api'], 'uses' => 'UserController@store']);
$router->put('users/{id}', ['middleware' => ['auth:api'], 'uses' => 'UserController@update']);
$router->delete('users/{id}', ['middleware' => ['auth:api'], 'uses' => 'UserController@destroy']);

/** Categories route */
$router->get('categories', ['middleware' => ['auth:api'], 'uses' => 'CategoryController@index']);
$router->post('categories', ['middleware' => ['auth:api'], 'uses' => 'CategoryController@store']);
$router->put('categories/{id}', ['middleware' => ['auth:api'], 'uses' => 'CategoryController@update']);
$router->delete('categories/{id}', ['middleware' => ['auth:api'], 'uses' => 'CategoryController@destroy']);

/** Items route */
$router->get('items', ['middleware' => ['auth:api'], 'uses' => 'ItemController@index']);
$router->get('items/{id}', ['middleware' => ['auth:api'], 'uses' => 'ItemController@show']);
$router->post('items', ['middleware' => ['auth:api'], 'uses' => 'ItemController@store']);
$router->put('items/{id}', ['middleware' => ['auth:api'], 'uses' => 'ItemController@update']);
$router->delete('items/{id}', ['middleware' => ['auth:api'], 'uses' => 'ItemController@destroy']);

/** Transactions route */
$router->get('transactions', ['middleware' => ['auth:api'], 'uses' => 'TransactionController@index']);
$router->get('transactions/{id}', ['middleware' => ['auth:api'], 'uses' => 'TransactionController@show']);
$router->post('transactions', ['middleware' => ['auth:api'], 'uses' => 'TransactionController@store']);
$router->post('transactions/update/waiting/{id}', ['middleware' => ['auth:api'], 'uses' => 'TransactionController@updateToWaiting']);
$router->post('transactions/update/appointment/{id}', ['middleware' => ['auth:api'], 'uses' => 'TransactionController@updateToAppointment']);
$router->post('transactions/update/map/{id}', ['middleware' => ['auth:api'], 'uses' => 'TransactionController@updateMap']);
$router->post('transactions/update/cancel/{id}', ['middleware' => ['auth:api'], 'uses' => 'TransactionController@updateToCancel']);
$router->delete('transactions/{id}', ['middleware' => ['auth:api'], 'uses' => 'TransactionController@destroy']);

/** Descriptions(Abouts) route */
$router->get('descriptions/{id}', ['middleware' => ['auth:api'], 'uses' => 'DescriptionController@show']);
$router->put('descriptions/{id}', ['middleware' => ['auth:api'], 'uses' => 'DescriptionController@update']);

/** Services route */
$router->get('services/{id}', ['middleware' => ['auth:api'], 'uses' => 'ServiceController@show']);
$router->put('services/{id}', ['middleware' => ['auth:api'], 'uses' => 'ServiceController@update']);

/** Policies route */
$router->get('policies/{id}', ['middleware' => ['auth:api'], 'uses' => 'PolicyController@show']);
$router->put('policies/{id}', ['middleware' => ['auth:api'], 'uses' => 'PolicyController@update']);

/** Support router */
$router->get('supports', ['middleware' => ['auth:api'], 'uses' => 'SupportController@index']);
$router->get('supports/{id}', ['middleware' => ['auth:api'], 'uses' => 'SupportController@show']);
$router->post('supports', ['middleware' => ['auth:api'], 'uses' => 'SupportController@store']);
$router->delete('supports/{id}', ['middleware' => ['auth:api'], 'uses' => 'SupportController@destroy']);