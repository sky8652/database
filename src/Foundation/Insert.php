<?php

namespace Waitmoonman\Database\Foundation;

class Insert extends Grammar
{
    public function toSql()
    {
        $sql = $this->compileStart();

        return $sql;
    }

    protected function compileStart()
    {
        $sql = "insert into {$this->builder->from} ";

        $params = '';
        $values = '';
        foreach ($this->params as $key => $value) {
            $params .= "{$key},";
            $values .= '?,';
            $this->builder->binds[] = $value;
        }
        $params = trim($params, ',');
        $values = trim($values, ',');

        $sql .= "({$params}) value({$values})";

        return $sql;
    }

    public function build($param = [])
    {
        $param = $this->buildParam($param);

        // 拼接原生 SQL
        $sql = $this->toSql();

        // 获取预处理 SQL 的参数
        $param = $this->compileParams();

        $this->builder->execute($sql, $param);

        // 获取 ID
        $results = $this->builder->dbh->lastInsertId();

        return $results;
    }
}
