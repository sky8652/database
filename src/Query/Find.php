<?php

namespace Waitmoonman\Database\Query;



use Waitmoonman\Database\Schema\Grammar;

class Find extends Grammar
{
    use Query;

    protected function compileWheres()
    {
        $primaryKey = $this->builder->getPrimaryKey();

        // where in
        if (count($this->params) == 1) {
            $wheres = "where {$primaryKey}=?";
        } else {
            // 填充问号和参数一样多
            $params = array_fill(0, count($this->params), '?');
            $ids = implode(',', $params);
            // 使用 where in
            $wheres = "where {$primaryKey} in ({$ids})";
        }


        return $wheres;
    }
}
