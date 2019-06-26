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
            'phone' => $this->getTelephoneTarget($notifiable, $notification),
            'body' => $context->content,
        ]);
    }

    protected function swapCredentials(string $instanceId, string $token): self
    {
        $this->client = $this->client->setCredentials($instanceId, $token);

        return $this;
    }

    protected function getTelephoneTarget($notifiable, Notification $notification): string
    {
        if ($notifiable->routeNotificationFor(ChatAPIChannel::class, $notification)) {
            return $notifiable->routeNotificationFor(ChatAPIChannel::class, $notification);
        }

        if ($notifiable->routeNotificationFor('ChatAPI', $notification)) {
            return $notifiable->routeNotificationFor('ChatAPI', $notification);
        }

        throw new CouldNotHandleTelephoneTargetException();
    }
}
