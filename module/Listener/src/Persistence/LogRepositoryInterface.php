<?php


namespace Listener\Persistence;


interface LogRepositoryInterface extends RepositoryInterface
{
    public function insert($log);
}