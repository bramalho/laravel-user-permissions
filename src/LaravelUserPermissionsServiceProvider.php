<?php

namespace BRamalho\LaravelUserPermissions;

use Illuminate\Support\ServiceProvider;

class LaravelUserPermissionsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/migrations' => base_path('database/migrations')
            ]
        );
    }

    /**
     * @return void
     */
    public function register()
    {
        //
    }
}
