<?php

namespace Waitmoonman\Database\Foundation;


trait Query
{
    protected function compileStart()
    {
        $selects = implode(', ', $this->builder->columns);

        return "select {$selects} from {$this->builder->from} ";
    }
}