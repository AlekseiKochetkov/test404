<?php


namespace Listener\Service;


use Listener\Model\Message;

class TelegramService implements MessangerServiceInterface
{
    public function send(Message $message): bool
    {
        return true;
    }
}