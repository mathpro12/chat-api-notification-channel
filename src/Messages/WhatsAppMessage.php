<?php

namespace Pedrommone\ChatAPINotificationChannel\Channels;

class WhatsAppMessage
{
    public $content;

    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
