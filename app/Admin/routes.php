<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/users', 'UsersController');
    $router->resource('/departments', 'DepartmentsController');
    $router->resource('/wages', 'WagesController');
    $router->resource('/quit_users', 'QuitUsersController');

});
