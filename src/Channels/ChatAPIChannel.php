<?php

namespace Pedrommone\ChatAPINotificationChannel\Channels;

use Illuminate\Notifications\Notification;
use Pedrommone\ChatAPI\Client;

class ChatAPIChannel
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send(WhatsAppMessage $notifiable, Notification $notification)
    {
        $this->client->messages()->send([
            'phone' => $notifiable->telephone,
            'body' => $notifiable->message,
        ]);
    }
}
