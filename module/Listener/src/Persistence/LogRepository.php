<?php


namespace Test404\Listener\Persistence;


use Test404\Listener\Model\MessageLog;

class LogRepository extends Repository implements LogRepositoryInterface
{
    protected $table = 'log';

    public function insert($log)
    {
        if(!$log instanceof MessageLog){
            return false;
        }
        parent::insert((array) $log);
    }
}