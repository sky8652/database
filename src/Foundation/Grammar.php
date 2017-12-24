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
        $sql = $this->compileColumns();

        return $sql;
    }

    public function build($param = [])
    {
        $sql = $this->toSql();
    }

    protected function compileWheres()
    {

    }

    protected function compileColumns()
    {
        if (is_null($this->builder->columns) || in_array('*', $this->builder->columns)) {
            $columns = '*';
        } else {
            $columns = explode(' ', $this->builder->columns);
        }

        $select = "select " . $columns;

        return $select;
    }
}