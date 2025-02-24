<?php

namespace Idl\Mailing;

use \illuminate\support\ServiceProvider;

class MailingServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/mailing.php' => config_path('mailing.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/config/mailing.php',
            'mailing'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
