<?php

namespace Modules\Invoice\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class InvoiceServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('Invoice', 'Database/Migrations'));
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
            module_path('Invoice', 'Config/config.php') => config_path('invoice.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Invoice', 'Config/config.php'), 'invoice'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/invoice');

        $sourcePath = module_path('Invoice', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/invoice';
        }, \Config::get('view.paths')), [$sourcePath]), 'invoice');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/invoice');

        $attributesPath = module_path('Invoice','Resources/lang/'.app()->getLocale().'/attributes.php');
        if(file_exists($attributesPath))
            setValidationAttributes(include $attributesPath);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'invoice');
        } else {
            $this->loadTranslationsFrom(module_path('Invoice', 'Resources/lang'), 'invoice');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Invoice', 'Database/factories'));
        }
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
