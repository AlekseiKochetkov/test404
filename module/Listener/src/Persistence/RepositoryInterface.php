<?php


namespace Listener\Persistence;


interface RepositoryInterface
{
    public function fetch(array $conditions=null);

    public function insert($model);
}