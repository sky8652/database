<?php

namespace Waitmoonman\Database\Schema;

use Closure;
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

    public $listenHandle = [];

    protected $queryMethod = ['insert', 'delete', 'update', 'first', 'get', 'find'];
    protected $convergeMethod = ['count', 'max', 'min', 'sum'];

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

    public function orderBy($field, $order = 'asc')
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

    public function getExecuteResults($sql, $parameters = [], $method = 'query')
    {
        // 预处理 SQL
        $statement = $this->dbh->prepare($sql);
        // 执行预处理语句
        $statement->execute($parameters);

        // 根据操作返回对应的结果
        switch ($method) {
            case 'query':
            case 'find':
                // 获取返回结果集rowCount
                return $statement->fetchAll(PDO::FETCH_OBJ);
                break;
            case 'update':
            case 'delete':
                return $statement->rowCount();
                break;
            case 'insert':
                return $this->dbh->lastInsertId();
                break;
            default:
                throw new QueryException('无效的执行操作');
                break;
        }

    }


    public function listenSql(Closure $closure, $realSql = false)
    {

        $this->listenHandle['action'] = $closure;
        $this->listenHandle['realSql'] = $realSql;

        return $this;
    }

    public function __call($method, $parameters)
    {
        $class = '\\Waitmoonman\\Database';


        if (in_array($method, $this->convergeMethod)) {
            $class .= '\\Functions\\';
        }elseif (in_array($method, $this->queryMethod)) {
            $class .= '\\Query\\';
        }else {
            throw new QueryException("方法 [{$method}] 不存在");
        }


        $class .= ucfirst($method);
        return (new $class($this))->build(...$parameters);

    }

    protected function initBuilder()
    {
        $this->columns = ['*'];
    }


}
