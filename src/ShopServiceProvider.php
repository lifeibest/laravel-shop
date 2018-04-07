<?php
namespace Lifeibest\LaravelShop;

use Illuminate\Support\ServiceProvider;

class ShopServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $commands = [
        //'Lifeibest\LaravelShop\Console\TaskCommand',
    ];

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->registerRoutes();
    }

    /**
     * Register the   manager routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'prefix' => 'admin',
            'namespace' => 'Lifeibest\LaravelShop\Admin\Http\Controllers',
            'middleware' => config('shop.admin_middleware', ['web', 'admin']),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
        });

        Route::group([
            'prefix' => config('shop.base_path', 'shop'),
            'namespace' => 'Lifeibest\LaravelPm\Http\Controllers',
            'middleware' => config('shop.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

}
