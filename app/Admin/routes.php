<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get("/users/{id}/email", 'UsersController@email');
    $router->put("/users/{id}/sms_email", 'UsersController@smsEmail');
    $router->get('/users/d_id', 'UsersController@d_id');
    $router->resource('/users', 'UsersController');
    $router->resource('/departments', 'DepartmentsController');
    $router->resource('/wages', 'WagesController');
    $router->resource('/quit_users', 'QuitUsersController');

});
