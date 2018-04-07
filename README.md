# laravel-shop
shop management

# Installation

You may use Composer to install laravel-shop into your Laravel project:

```shell
composer require lifeibest/laravel-shop:dev-master




After installing `laravel-shop`, publish its config using the vendor:publish Artisan command:

```shell
php artisan vendor:publish --provider="Lifeibest\LaravelShop\ShopServiceProvider"
`



migrate database

```shell
php artisan migrate --path=vendor/lifeibest/laravel-shop/database/migrations
```

import menu and permission

```shell
php artisan admin:import shop
```