<?php

namespace Hyperpay\Payment;

use Hyperpay\Payment\Components\HyperPayForm;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class HyperpayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'HyperPayForm');
        $this->loadViewComponentsAs('hyper-pay', [HyperPayForm::class]);

        Blade::component('hyper-pay-form' , HyperPayForm::class);

        $this->publishes([
            __DIR__ . '/config/payments.php' => config_path('payments.php'),
        ], 'config');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'paymet');

        $this->publishes([
            __DIR__ . '/lang' => $this->app->langPath('hyperpay/paymet'),
        ], 'config');
        $this->publishes([
            __DIR__.'/resources/js' => public_path('hyperpay'),
        ], 'config');
        $this->publishes([
            __DIR__.'/resources/css' => public_path('hyperpay'),
        ], 'config');
        $this->publishes([
            __DIR__.'/Controllers/PaymentController.php' => app_path('Http/Controllers/PaymentController.php'),
        ], 'config');


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
