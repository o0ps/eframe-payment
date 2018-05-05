<?php

namespace EFrame\Payment;

use EFrame\Payment\Payment;
use EFrame\Payment\Gateways\WayForPay;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register the application services
     */
    public function register()
    {
        $this->registerGateways();
        $this->registerPayment();
    }

    /**
     * Register Payment service
     */
    protected function registerPayment()
    {
        $this->app->singleton('payment', function () {
            return new Payment(
                new GatewayFactory($this->config('gateways')),
                $this->config('default')
            );
        });
    }

    /**
     * Register payment services
     */
    protected function registerGateways()
    {
        $this->registerWayForPay();
    }

    /**
     * Register WayForPay service
     */
    protected function registerWayForPay()
    {
        $this->app->bind('wayforpay', WayForPay::class);
    }

    /**
     * @param null $key
     * @param null $default
     *
     * @return mixed
     */
    protected function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return config('payment');
        }

        return config("payment.{$key}", $default);
    }

    /**
     * Bootstrap the application services
     */
    public function boot()
    {
        $config = realpath(__DIR__ . '/config/payment.php');
        $this->mergeConfigFrom($config, 'payment');
    }
}