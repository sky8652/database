<?php

namespace Waitmoonman\Database\Query;

trait Query
{
    protected function compileStart()
    {
        $selects = implode(', ', $this->builder->columns);

        return "select {$selects} from {$this->builder->from} ";
    }
}
