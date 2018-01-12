<?php

namespace Waitmoonman\Database\Foundation;

use Waitmoonman\Database\Contracts\DataBaseInterface;
use Waitmoonman\Database\Query\Builder;

abstract class Grammar implements DataBaseInterface
{
    protected $builder;

    protected $params;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function toSql()
    {
        $sql = $this->compileStart();

        $sql .= $this->compileWheres();

        return $sql;
    }

    public function build($param = [])
    {
        $param = $this->buildParam($param);

        // 拼接原生 SQL
        $sql = $this->toSql();

        // 获取预处理 SQL 的参数
        $param = $this->compileParams();

        $results = $this->builder->execute($sql, $param);

        return $results;
    }

    protected function compileWheres()
    {
        if (empty($this->builder->wheres)) {
            return '';
        }

        // wheres[''] -> 'column', 'operator', 'value'
        $wheres = 'where ';
        foreach ($this->builder->wheres as $where) {
            $wheres .= "{$where['column']}  {$where['operator']} ? and ";
            $this->builder->binds[] = $where['value'];
        }

        $wheres = rtrim($wheres, 'and ');

        return $wheres;
    }

    /**
     * operate $this->table.
     */
    protected function compileStart()
    {
        return '';
    }

    protected function compileParams()
    {
        var_dump(array_merge($this->builder->binds));
        /*
         * 条件的参数先，然后再到后面的参数
         * Builder->where('sex', 1)->update($param);
         */
        return $this->builder->binds;
    }

    protected function buildParam($param)
    {
        // find() 参数不是数组
        if (!is_array($param)) {
            $param = (array) $param;
        }
        $this->params = $param;

        return $this->params;
    }
}
