<?php


namespace Test404\Listener\Persistence;


interface LogRepositoryInterface extends RepositoryInterface
{
    public function insert($log);
}