<?php

namespace Waitmoonman\Database\Query;



use Waitmoonman\Database\Schema\Grammar;

class Find extends Grammar
{
    use Query;

    protected function compileWheres()
    {
        $primaryKey = $this->builder->getPrimaryKey();

        $wheres = "where {$primaryKey}=?";

        return $wheres;
    }
}
