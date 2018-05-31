# Laravel User Permissions Package

[![Latest Stable Version](https://poser.pugx.org/bramalho/laravel-user-permissions/v/stable)](https://packagist.org/packages/bramalho/laravel-user-permissions)
[![Total Downloads](https://poser.pugx.org/bramalho/laravel-user-permissions/downloads)](https://packagist.org/packages/bramalho/laravel-user-permissions)
[![License](https://poser.pugx.org/bramalho/laravel-user-permissions/license)](https://packagist.org/packages/bramalho/laravel-user-permissions)

Laravel User Permissions is a Laravel package that provide a really simple user roles and permissions management.

## Installation
Install the package
```sh
composer require bramalho/laravel-user-permissions
```

Add the service provider in `config/app.php`

```php
BRamalho\LaravelUserPermissions\LaravelUserPermissionsServiceProvider::class,
```

Publish the configs
```sh
php artisan vendor:publish --provider 'BRamalho\LaravelUserPermissions\LaravelUserPermissionsServiceProvider'
```

Add the Permission trait to your User model
```php
<?php

namespace App;

use BRamalho\LaravelUserPermissions\Permission;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Permission;

    //...
}
```

Register the Middleware in `app\Http\Kernel.php`
```php
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use BRamalho\LaravelUserPermissions\UserRoleMiddleware;
use BRamalho\LaravelUserPermissions\UserHasPermissionMiddleware;

class Kernel extends HttpKernel
{
    // ...

    protected $routeMiddleware = [
        // ...
        'role' => \App\Http\Middleware\UserRole::class,
        'user.can' => \App\Http\Middleware\UserCan::class
    ];
}
```

Run migrations

```sh
php artisan migrate
```

## Usage

You can assing or remove roles simply like this
```php
<?php

use Illuminate\Database\Seeder;
use App\User;
use BRamalho\LaravelUserPermissions\UserRole;
use BRamalho\LaravelUserPermissions\UserPermission;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@app.local',
            'password' => bcrypt('admin')
        ]);
        User::create([
            'id' => 2,
            'name' => 'Publisher',
            'email' => 'publisher@app.local',
            'password' => bcrypt('publisher')
        ]);

        UserRole::create(
            [
                'id'    => 1,
                'name'  => 'Admin'
            ]
        );
        UserRole::create(
            [
                'id'    => 2,
                'name'  => 'Publisher'
            ]
        );

        UserPermission::create(
            [
                'id'            => 1,
                'user_role_id'  => 2,
                'module'        => 'pages',
                'action'        => 'view'
            ]
        );
        UserPermission::create(
            [
                'id'            => 2,
                'user_role_id'  => 2,
                'module'        => 'pages',
                'action'        => 'add'
            ]
        );
        UserPermission::create(
            [
                'id'            => 3,
                'user_role_id'  => 2,
                'module'        => 'pages',
                'action'        => 'edit'
            ]
        );

        $userAdmin = User::find(1);
        $roleAdmin = UserRole::find(1);
        $userAdmin->assignRole($roleAdmin);
        //$userPublisher->removeRole($roleAdmin);

        $userPublisher = User::find(2);
        $rolePublisher = UserRole::find(2);
        $userPublisher->assignRole($rolePublisher);
        //$userPublisher->removeRole($rolePublisher);
    }
}
```

To use the middlware in your routes
```php
Route::get('/page/{id}', 'PageController@index')->name('page')->middleware('permission:pages,view');
Route::get('/page/{id}/add', 'PageController@add')->name('pageAdd')->middleware('permission:pages,add');
Route::get('/page/{id}/edit', 'PageController@add')->name('pageAdd')->middleware('permission:pages,edit');
Route::delete('/page/{id}/delete', 'PageController@delete')->name('pageDelete')->middleware('permission:pages,delete');
```

## License
The **Laravel User Permissions** is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
