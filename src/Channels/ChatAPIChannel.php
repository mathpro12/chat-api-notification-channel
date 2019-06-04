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
        $context = $notification->toChatAPI($notifiable);

        if (!is_null($context->instanceId) && !is_null($context->token)) {
            $this->swapCredentials($context->instanceId, $context->token);
        }

        $this->client->messages()->send([
            'phone' => $this->getTelephoneTarget($notifiable),
            'body' => $context->content,
        ]);
    }

    protected function swapCredentials(string $instanceId, string $token): self
    {
        $this->client = $this->client->setCredentials($instanceId, $token);

        return $this;
    }

    protected function getTelephoneTarget($notifiable): string
    {
        if ($notifiable->routeNotificationFor(ChatAPIChannel::class)) {
            return $notifiable->routeNotificationFor(ChatAPIChannel::class);
        }

        if ($notifiable->routeNotificationFor('ChatAPI')) {
            return $notifiable->routeNotificationFor('ChatAPI');
        }

        throw new CouldNotHandleTelephoneTargetException();
    }
}
