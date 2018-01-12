<?php

namespace Waitmoonman\Database\Foundation;

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
