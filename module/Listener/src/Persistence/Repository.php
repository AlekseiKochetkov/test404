<?php


namespace Listener\Persistence;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class Repository implements RepositoryInterface
{
    protected $sql;

    protected $table;

    protected $primaryKey = 'id';

    public function __construct()
    {
        $adapter = new Adapter([
            'driver'   => 'Pdo_Mysql',
            'database' => 'test404',
            'username' => 'user',
            'password' => 'password',
        ]);
        $this->sql = new Sql($adapter);
    }


    public function fetch(array $conditions = null)
    {
        $select = $this->sql->select($this->table);
        if (isset($conditions)) {
            $select->where($conditions);
        }
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results;
    }

    public function insert($model)
    {
        $insert = $this->sql->insert($this->table);
        $insert->values($model);
        $statement = $this->sql->prepareStatementForSqlObject($insert);
        $results = $statement->execute();
        return $results;
    }
}
