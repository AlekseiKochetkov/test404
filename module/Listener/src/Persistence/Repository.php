<?php


namespace Test404\Listener\Persistence;

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
            'hostname' => '172.16.0.3',
            'database' => 'test404',
            'username' => 'user',
            'password' => 'password',
            'dsn'      => 'mysql:'.
                'dbname=test404;'.
                'host=172.16.0.3;',
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
        foreach ($model as $key=>$value){
            if(!isset($value) || is_null($value)){
                unset($model[$key]);
            }
        }
        $insert->values($model);
        $statement = $this->sql->prepareStatementForSqlObject($insert);
        $results = $statement->execute();
        return $results;
    }
}
