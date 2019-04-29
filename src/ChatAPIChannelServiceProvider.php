<?php

namespace Pedrommone\ChatAPINotificationChannel;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use Pedrommone\ChatAPI\Client;
use Pedrommone\ChatAPINotificationChannel\Channels\ChatAPIChannel;

class ChatAPIChannelServiceProvider extends ServiceProvider
{
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('ChatAPI', function ($app) {
                return new ChatAPIChannel(
                    new Client(
                        config('services.what_api.intance_id'),
                        config('services.what_api.token')
                    )
                );
            });
        });
    }
}
