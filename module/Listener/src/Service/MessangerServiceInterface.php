<?php


namespace Listener\Service;


use Listener\Model\Message;

interface MessangerServiceInterface
{
    public function send(Message $message):bool;
}