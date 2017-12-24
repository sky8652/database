<?php

namespace Waitmoonman\Database\Query;

use PDO;

class Builder
{
    /**
     * 数据库连接句柄
     */
    public $dbh;

    public $columns;
    public $from;
    public $offset;
    public $limit;
    public $orders;
    public $wheres = [];
    public $binds = [];

    public function __construct(PDO $dbh)
    {
        $this->dbh = $dbh;
    }

    public function select($column = ['*'])
    {
        $this->column = $column;

        return $this;
    }

    public function table($from)
    {
        $this->from = $from;

        return $this;
    }


    public function offset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function orderBy($field, $order = 'ASC')
    {
        $this->orders[$field] = $order;

        return $this;
    }

    public function where($column, $operator = null, $value = null)
    {
        if (func_num_args() == 2) {
            list($column, $value) = [$column, $operator];
            $operator = '=';
        }

        $this->wheres[] = compact(
            'column', 'operator', 'value'
        );

        return $this;
    }

    public function get()
    {

        $results = $this->processor->processSelect($this, $this->runSelect());

        $this->columns = $original;

        return collect($results);
    }

    public function toSql()
    {

    }

    public function execute($sql, $parameters)
    {
       $statement = $this->dbh->prepare($sql);
        $statement->execute($parameters);

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function __call($method, $parameters)
    {
        if (in_array($method, ['insert', 'delete', 'update'])) {
            $class = "\\Waitmoonman\\Database\\Foundation\\" . ucfirst($method);

            return (new $class($this))->build(...$parameters);
        }
    }
}