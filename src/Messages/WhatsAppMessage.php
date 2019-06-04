<?php

namespace Pedrommone\ChatAPINotificationChannel\Channels;

class WhatsAppMessage
{
    public $content;
    public $instanceId;
    public $token;

    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function credentials(string $instanceId, string $token): self
    {
        $this->instanceId = $instanceId;
        $this->token = $token;

        return $this;
    }
}
