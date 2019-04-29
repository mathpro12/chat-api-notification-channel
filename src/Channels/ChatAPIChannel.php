<?php

namespace Pedrommone\ChatAPINotificationChannel\Channels;

use Illuminate\Notifications\Notification;
use Pedrommone\ChatAPI\Client;
use Pedrommone\ChatAPINotificationChannel\Exceptions\CouldNotHandleTelephoneTargetException;

class ChatAPIChannel
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification)
    {
        $this->client->messages()->send([
            'phone' => $this->getTelephoneTarget($notifiable),
            'body' => $notification->toChatAPI($notifiable)->content,
        ]);
    }

    protected function getTelephoneTarget($notifiable): string
    {
        if ($notifiable->routeNotificationFor('ChatAPI')) {
            return $notifiable->routeNotificationFor('ChatAPI');
        }

        throw new CouldNotHandleTelephoneTargetException();
    }
}
