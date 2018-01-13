<?php

namespace Waitmoonman\Database\Query;

use PDO;
use Waitmoonman\Database\Exceptions\QueryException;

class Builder
{
    /**
     * 数据库连接句柄.
     */
    public $dbh;

    public $primaryKey;

    public $columns;

    public $from;

    public $offset;

    public $limit;

    public $orders;

    public $wheres = [];

    public $binds = [];

    protected $method = ['insert', 'delete', 'update', 'first', 'get', 'find'];

    public function __construct(PDO $dbh)
    {
        $this->dbh = $dbh;
        // 初始化构造 SQL
        $this->initBuilder();
    }

    public function select(...$column)
    {
        // 重置前一次的
        $this->columns = [];

        foreach (func_get_args() as $param) {
            $this->columns[] = $param;
        }

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
        if (2 === func_num_args()) {
            list($column, $value) = [$column, $operator];
            $operator = '=';
        }

        $this->wheres[] = compact(
            'column', 'operator', 'value'
        );

        return $this;
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey ?: 'id';
    }

    public function execute($sql, $parameters = [])
    {
        $statement = $this->dbh->prepare($sql);

        // 重置参数的键
        $parameters = array_values($parameters);

        $statement->execute($parameters);

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function __call($method, $parameters)
    {
        if (in_array($method, $this->method)) {
            $class = '\\Waitmoonman\\Database\\Foundation\\'.ucfirst($method);

            return (new $class($this))->build(...$parameters);
        }

        throw new QueryException("NOT METHOD {$method}");
    }

    protected function initBuilder()
    {
        $this->columns = ['*'];
    }
}
