<?php

namespace Waitmoonman\Database\Functions;

use Waitmoonman\Database\Schema\Grammar;

class Converge extends Grammar
{
    protected $asName = '';

    public function compileStart()
    {
        $column = '*';
        if (is_array($this->builder->columns)) {
            $column = current($this->builder->columns);
        }

        $function = $this->getBaseClass();

        $start = "select {$function}({$column}) {$this->asName} from {$this->builder->from} ";

        return $start;
    }

    public function setAsName($name)
    {
        $this->asName = "as {$name}";

        return $this;
    }
}