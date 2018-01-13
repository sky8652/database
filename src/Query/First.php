<?php

namespace Waitmoonman\Database\Query;



use Waitmoonman\Database\Schema\Grammar;

class First extends Grammar
{
    use Query;

    public function compileEnd()
    {
        // 设置返回的条数
        $this->builder->limit(1);

        return parent::compileEnd();
    }
}
