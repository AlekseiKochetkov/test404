<?php


namespace Test404\Listener\Service;


use Test404\Listener\Model\Message;

interface MessangerServiceInterface
{
    public function send(Message $message):bool;
}