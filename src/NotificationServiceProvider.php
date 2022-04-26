<?php
namespace Snp\Notifications\Rml;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Snp\Notifications\Rml\Channels\RmlViberChannel;

class NotificationServiceProvider  extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__.'/config/services.php', 'services'
        );

        Notification::resolved(function (ChannelManager $service) {
            $service->extend(config('services.route-mobile-notifications.name', 'RMLViber'), function ($app) {
                return new RmlViberChannel($app->make(config('services.route-mobile-notifications.gateway')));
            });
        });
    }
}