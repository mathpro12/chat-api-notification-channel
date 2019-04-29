<?php

namespace Pedrommone\ChatAPINotificationChannel\Channels;

class WhatsAppMessage
{
    public $message;
    public $telephone;

    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function telephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
