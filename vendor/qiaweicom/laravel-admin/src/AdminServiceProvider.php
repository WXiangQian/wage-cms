<?php

namespace Qiaweicom\Admin;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        'Qiaweicom\Admin\Console\MakeCommand',
        'Qiaweicom\Admin\Console\MenuCommand',
        'Qiaweicom\Admin\Console\InstallCommand',
        'Qiaweicom\Admin\Console\UninstallCommand',
        'Qiaweicom\Admin\Console\ImportCommand',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.auth'       => \Qiaweicom\Admin\Middleware\Authenticate::class,
        'admin.pjax'       => \Qiaweicom\Admin\Middleware\Pjax::class,
        'admin.log'        => \Qiaweicom\Admin\Middleware\LogOperation::class,
        'admin.permission' => \Qiaweicom\Admin\Middleware\Permission::class,
        'admin.bootstrap'  => \Qiaweicom\Admin\Middleware\Bootstrap::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin' => [
            'admin.auth',
            'admin.pjax',
            'admin.log',
            'admin.bootstrap',
            'admin.permission',
        ],
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'admin');

        if (file_exists($routes = admin_path('routes.php'))) {
            $this->loadRoutesFrom($routes);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'laravel-admin-config');
            $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang')], 'laravel-admin-lang');
//            $this->publishes([__DIR__.'/../resources/views' => resource_path('views/admin')],           'laravel-admin-views');
            $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'laravel-admin-migrations');
            $this->publishes([__DIR__.'/../resources/assets' => public_path('vendor/laravel-admin')], 'laravel-admin-assets');
        }

        //remove default feature of double encoding enable in laravel 5.6 or later.
        $bladeReflectionClass = new \ReflectionClass('\Illuminate\View\Compilers\BladeCompiler');
        if ($bladeReflectionClass->hasMethod('withoutDoubleEncoding')) {
            Blade::withoutDoubleEncoding();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadAdminAuthConfig();

        $this->registerRouteMiddleware();

        $this->commands($this->commands);
    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function loadAdminAuthConfig()
    {
        config(array_dot(config('admin.auth', []), 'auth.'));
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}
