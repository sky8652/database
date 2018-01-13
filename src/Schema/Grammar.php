<?php

namespace Waitmoonman\Database\Schema;

use Closure;
use Waitmoonman\Database\Contracts\DataBaseInterface;

class Grammar implements DataBaseInterface
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
        $sql .= $this->compileEnd();

        return $sql;
    }

    public function build($params = [])
    {
        // 拼接原生 SQL
        $sql = $this->toSql();

        // 获取预处理 SQL 的参数
        $parameters = $this->compileParams();


        // 是否监听 SQL
        if (! empty($this->builder->listenHandle)) {
            $this->listenBuilderSql($sql, $parameters);
        }

        // 执行 SQL 运行
        $results = $this->builder->getExecuteResults($sql, $parameters);

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


    protected function compileStart()
    {
        return '';
    }

    protected function compileEnd()
    {
        $end = '';

        // 排序
        if (! is_null($this->builder->orders)) {
            $end .= ' order by ';
            foreach ($this->builder->orders as $field => $order) {
                $end .= "{$field} {$order},";
            }
            $end = rtrim($end, ',');
        }

        // 限制结果集
        if (! is_null($this->builder->limit)) {
            $end .= " limit ";
            if (! is_null($this->builder->offset)) {
                $end .= "{$this->builder->offset},";
            }
            $end .= $this->builder->limit;
        }

        return $end;
    }

    protected function compileParams()
    {
        /*
         * 条件的参数先，然后再到后面的参数
         * Builder->where('sex', 1)->update($param);
         */
        return $this->builder->binds = array_values($this->builder->binds);
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

    private function listenBuilderSql($sql, $parameters)
    {
        $listenParams = [$sql, $parameters];
        // 需要拼接出货 SQL
        if ($this->builder->listenHandle['realSql']) {
            $listenParams[] = $this->getRealSql($sql, $parameters);
        }

        call_user_func_array($this->builder->listenHandle['action'], $listenParams);
    }

    private function getRealSql($sql, $parameters)
    {
        $realSql = '';
        for ($i = 0, $l = strlen($sql); $i < $l; ++ $i) {

            if ($sql{$i} == '?') {
                $realSql .= array_shift($parameters);
            } else {
                $realSql .= $sql{$i};
            }
        }

        return $realSql;
    }
}
