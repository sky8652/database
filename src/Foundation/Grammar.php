<?php

namespace Waitmoonman\Database\Foundation;

use Waitmoonman\Database\Contracts\DataBaseInterface;
use Waitmoonman\Database\Query\Builder;

abstract class Grammar implements DataBaseInterface
{
    protected $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function toSql()
    {
        // TODO 动态拼接 update delete insert into
        $sql = $this->compileStart();

        $sql .= $this->compileWheres();

        return $sql;
    }

    public function build($param = [])
    {
        $sql = $this->toSql();

        $results = $this->builder->execute($sql, $this->builder->binds);
        var_dump($sql, $results);
    }

    protected function compileWheres()
    {
        var_dump($this->builder);
        if (empty($this->builder->wheres)) {
            return '';
        }

        // wheres[''] -> 'column', 'operator', 'value'
        $wheres = 'where ';
        foreach ($this->builder->wheres as $where) {
            $wheres .= $where['column'] . ' ' . $where['operator'] . ' ? and ';
            $this->builder->binds[] = $where['value'];
        }

        $wheres = rtrim($wheres, 'and ');

        return $wheres;
    }

    protected function compileStart()
    {
        $operate = strtolower(basename(static::class));

        $sql = '';
        switch ($operate) {
            case 'insert':
                $sql = 'insert into ';
                break;
            case 'update':
                $sql = 'update ';
                break;
            case 'delete':
                $sql = 'delete from ';
                break;
            default:
                $sql = 'insert into ';
                break;
        }

        $sql .= "`{$this->builder->from}` ";


        return $sql;
    }
}