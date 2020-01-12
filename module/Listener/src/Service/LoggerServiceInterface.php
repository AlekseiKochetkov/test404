<?php


namespace Listener\Service;


use Listener\Model\MessageLog;

interface LoggerServiceInterface
{
    public function checkLog():bool;

    public function log(MessageLog $log);
}