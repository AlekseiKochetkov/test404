<?php


namespace Test404\Listener\Service;


use Test404\Listener\Model\Message;

class TelegramService implements MessangerServiceInterface
{
    public function send(Message $message): bool
    {
        return true;
    }
}