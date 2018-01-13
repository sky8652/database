<?php

namespace Waitmoonman\Database\Functions;

use Waitmoonman\Database\Schema\Grammar;

class Converge extends Grammar
{
    public function compileStart()
    {
        $column = '*';
        if (is_array($this->builder->columns)) {
            $column = current($this->builder->columns);
        }

        $function = $this->getBaseClass();

        $start = "select {$function}({$column}) from {$this->builder->from} ";

        return $start;
    }

    protected function getBaseClass()
    {
        $class = basename(get_class($this));

        $class = strtolower($class);

        return $class;
    }
}