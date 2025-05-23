<?php
namespace App\Tocaan\Payments;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
// use App\Tocaan\Subscriptions\Console\SubscriptionDependenciesCheck;

class PaymentsServiceProvider extends ServiceProvider
{
    const PAYMENTSPATH = 'Tocaan/Payments';

    public function register()
    {
        $this->registerConfig();
    }

    public function boot()
    {
        $this->checkDependencies();

        $this->registerMigrations();
        $this->registerRoutes();

        // $this->commands([
        //     SubscriptionDependenciesCheck::class,
        // ]);
    }

    protected function registerMigrations()
    {
        $this->loadMigrationsFrom([
            app_path(self::PAYMENTSPATH . "/Database/Migrations")
        ]);
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom( app_path(self::PAYMENTSPATH . "/Config/config.php") , 'payments');
    }

    protected function registerRoutes()
    {
        Route::group([
            'prefix' => 'payments',
            'namespace' => '\App\Tocaan\Payments\Http\Controllers',
            'as' => 'payments.',
            'middleware' => 'web'
        ], function () {
            $this->loadRoutesFrom(app_path(self::PAYMENTSPATH . "/routes/web.php"));
        });
    }

    protected function checkDependencies()
    {
        $file = app_path(self::PAYMENTSPATH . "/Dependencies/Libs.php");
        if( \File::exists($file) )
        {
            $libs = require_once $file;

            if( !is_null($libs) && is_array($libs) && is_countable($libs) && count($libs) > 0 )
            {
                foreach($libs as $lib)
                {
                    if( !class_exists($lib) )
                    {
                        throw new \Exception('Dependency for Subscription lib does not found. ('.$lib.'). at '.__FILE__.': '.__LINE__);
                    }
                }
            }
        }
    }
}
