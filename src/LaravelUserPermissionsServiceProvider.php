<?php

namespace BRamalho\LaravelUserPermissions;

use Illuminate\Support\ServiceProvider;

class LaravelUserPermissionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../database/migrations' => base_path('database/migrations')
            ]
        );
    }

    public function register()
    {

    }
}
