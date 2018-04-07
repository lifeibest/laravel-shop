<?php
namespace Lifeibest\LaravelShop;

use Encore\Admin\Admin;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Permission;
use Illuminate\Support\Facades\Route;
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
        $this->registerResources();
        $this->definePublishing();

        //$this->registerCommands();

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }
        Admin::extend('shop', __CLASS__);

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
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

    /**
     * Register the   manager resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'shop');
    }

    /**
     * Define the publishing.
     *
     * @return void
     */
    public function definePublishing()
    {

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/shop'),
        ], 'shop-assets');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/shop.php' => config_path('shop.php'),
            ], 'shop-config');
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        $lastOrder = Menu::max('order');
        $root = [
            'parent_id' => 0,
            'order' => $lastOrder++,
            'title' => '产品管理',
            'icon' => 'fa-tasks',
            'uri' => '',
        ];
        $root = Menu::create($root);
        $menus = [
            [
                'title' => '产品管理',
                'icon' => 'fa-tasks',
                'uri' => 'shop-product',
            ],
            [
                'title' => '产品属性',
                'icon' => 'fa-terminal',
                'uri' => 'shop-product-attr',
            ],
        ];
        foreach ($menus as $menu) {
            $menu['parent_id'] = $root->id;
            $menu['order'] = $lastOrder++;
            Menu::create($menu);
        }

        Permission::create([
            'name' => 'Product Management',
            'slug' => 'ext.shop',
            'http_path' => '/' . trim('product*', '/'),
        ]);
    }

}
