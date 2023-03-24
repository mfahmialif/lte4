<?php

namespace Mfahmialif\Lte4;

use Illuminate\Support\ServiceProvider;

class LTEServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/views' => resource_path('views'),
            __DIR__ . '/public' => public_path('/'),
            __DIR__ . '/controller' => base_path('/app/Http/Controllers'),
            __DIR__ . '/middleware' => base_path('/app/Http/Middleware'),
            __DIR__ . '/service' => base_path('/app/Http/Services'),
            __DIR__ . '/model' => base_path('/app/Models'),
            __DIR__ . '/routes' => base_path('/routes'),
            __DIR__ . '/migrations' => base_path('/database/migrations'),
            __DIR__ . '/seeders' => base_path('/database/seeders'),
        ], 'lte4');
    }

    public function register()
    {
    }
}
