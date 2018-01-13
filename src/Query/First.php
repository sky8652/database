<?php

namespace Waitmoonman\Database\Query;



use Waitmoonman\Database\Schema\Grammar;

class First extends Grammar
{
    use Query;

    public function toSql()
    {
        // TODO 动态拼接 update delete insert into
        $sql = $this->compileStart();

        $sql .= $this->compileWheres();

        $sql .= ' limit 1';

        return $sql;
    }
}
