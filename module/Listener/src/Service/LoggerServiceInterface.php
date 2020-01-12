<?php


namespace Listener\Service;


use Listener\Model\Message;
use Listener\Model\MessageLog;

interface LoggerServiceInterface
{
    public function checkLog(Message $message):bool;

    public function log(MessageLog $log) ;
}