<?php

namespace Waitmoonman\Database\Foundation;


class Get extends Grammar
{
    public function build($param = [])
    {
        $this->params = $param;

        // 拼接原生 SQL
        $sql = $this->toSql();
        // 获取预处理 SQL 的参数
        $param = $this->compileParams($param);

        $results = $this->builder->execute($sql, $param);

        return $results;
    }


    protected function compileStart()
    {
        $selects = implode(', ', $this->builder->columns);

        return "select {$selects} from {$this->builder->from} ";
    }
}