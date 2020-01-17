<?php


namespace Test404\Listener\Service;


use Test404\Listener\Model\Message;
use Test404\Listener\Model\MessageLog;

interface LoggerServiceInterface
{
    public function checkLog(Message $message):bool;

    public function log(MessageLog $log) ;
}