<?php

namespace Arjasco\ClockworkSms;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use mediaburst\ClockworkSMS\Clockwork;

class ClockworkSMSServiceProvider extends ServiceProvider
{
    /**
     * Boot the application services.
     *
     * @return void
     */
    public function boot()
    {
        $manager = $this->app->make(ChannelManager::class);

        $manager->extend('clockwork-sms', function () {
            return new ClockworkSmsChannel(
                new Clockwork($this->app['config']['services.clockwork-sms.key']),
                $this->app['config']['services.clockwork-sms.from']
            );
        });
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