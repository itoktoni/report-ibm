<?php

namespace Modules\Report\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Config;
use Modules\Report\Dao\Models\SoDetail;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('Report.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'Report'
        );

        $this->app->bind('customer_facades', function () {
            return new \Modules\Report\Dao\Repositories\CustomerRepository();
        });
        $this->app->bind('payment_facades', function () {
            return new \Modules\Report\Dao\Repositories\PaymentRepository();
        });
        $this->app->bind('product_facades', function () {
            return new \Modules\Report\Dao\Repositories\ProductRepository();
        });
        $this->app->bind('so_facades', function () {
            return new \Modules\Report\Dao\Repositories\SoRepository();
        });
        $this->app->bind('so_detail_facades', function () {
            return new SoDetail();
        });
        $this->app->bind('supplier_facades', function () {
            return new \Modules\Report\Dao\Repositories\SupplierRepository();
        });
        $this->app->bind('team_facades', function () {
            return new \Modules\Report\Dao\Repositories\TeamRepository();
        });
        
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/Report');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/Report';
        }, Config::get('view.paths')), [$sourcePath]), 'Report');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/Report');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'Report');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'Report');
        }
    }

    /**
     * Register an additional directory of Repositories.
     *
     * @return void
     */
    public function registerFactories()
    {
        // if (! app()->environment('production')) {
        //     app(Factory::class)->load(__DIR__ . '/../Database/factories');
        // }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
