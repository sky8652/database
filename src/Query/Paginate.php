<?php

namespace Waitmoonman\Database\Query;


use Waitmoonman\Database\Schema\Grammar;

class Paginate extends Grammar
{
    use Query;

    public function toSql()
    {
        $sql = $this->compileStart();

        $sql .= $this->compileWheres();

        $sql .= ' limit 1';

        return $sql;
    }
}
