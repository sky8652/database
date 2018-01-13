<?php

namespace Waitmoonman\Database\Query;

use Waitmoonman\Database\Schema\Grammar;

class Insert extends Grammar
{

    protected function compileStart()
    {
        $sql = "insert into {$this->builder->from} ";

        $params = '';
        $values = '';
        foreach ($this->params as $key => $value) {
            $params .= "{$key},";
            $values .= '?,';
        }
        $params = trim($params, ',');
        $values = trim($values, ',');

        $sql .= "({$params}) value({$values})";

        return $sql;
    }

}
