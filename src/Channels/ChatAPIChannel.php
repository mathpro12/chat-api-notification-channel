<?php

namespace Pedrommone\ChatAPINotificationChannel\Channels;

use Illuminate\Log\Logger;
use Illuminate\Notifications\Notification;
use Pedrommone\ChatAPI\Client;

class ChatAPIChannel
{
    protected $client;
    protected $logger;

    public function __construct(Client $client, Logger $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function send($notifiable, Notification $notification)
    {
        $context = $notification->toChatAPI($notifiable);
        $target = $this->getTelephoneTarget($notifiable, $notification);

        if (!is_null($context->instanceId) && !is_null($context->token)) {
            $this->swapCredentials($context->instanceId, $context->token);
        }

        if (is_null($target) || strlen($target) === 0) {
            $this->logger->debug('Could not sent WhatsApp message because given phone is null or empty.');

            return false;
        }

        return $this->client->messages()->send([
            'phone' => $target,
            'body' => $context->content,
        ]);
    }

    protected function swapCredentials(string $instanceId, string $token): self
    {
        $this->client = $this->client->setCredentials($instanceId, $token);

        return $this;
    }

    protected function getTelephoneTarget($notifiable, Notification $notification): ?string
    {
        if ($notifiable->routeNotificationFor(ChatAPIChannel::class, $notification)) {
            return $notifiable->routeNotificationFor(ChatAPIChannel::class, $notification);
        }

        if ($notifiable->routeNotificationFor('ChatAPI', $notification)) {
            return $notifiable->routeNotificationFor('ChatAPI', $notification);
        }

        return null;
    }
}
