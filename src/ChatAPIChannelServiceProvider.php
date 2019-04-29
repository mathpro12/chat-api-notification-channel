<?php

namespace Pedrommone\ChatAPINotificationChannel;

use Illuminate\Support\ServiceProvider;
use Pedrommone\ChatAPI\Client;
use Pedrommone\ChatAPINotificationChannel\Channels\ChatAPIChannel;

class ChatAPIChannelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when(ChatAPIChannel::class)
            ->needs(Client::class)
            ->give(function () {
                return new Client(
                    config('services.chat_api.instance_id'),
                    config('services.chat_api.token')
                );
            });
    }
}
