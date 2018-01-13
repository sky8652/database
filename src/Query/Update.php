<?php

namespace Waitmoonman\Database\Foundation;



use Waitmoonman\Database\Schema\Grammar;

class Update extends Grammar
{
    public function compileStart($param = [])
    {
        $params = array_keys($this->params);

        $sql = 'update '.$this->builder->from.' set ';

        foreach ($params as $param) {
            $sql .= "{$param}=?,";
        }

        $sql = rtrim($sql, ',');
        $sql .= ' ';

        return $sql;
    }
}
