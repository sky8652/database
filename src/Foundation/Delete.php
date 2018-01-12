<?php

namespace Waitmoonman\Database\Foundation;

use Waitmoonman\Database\Query\Builder;

class Delete extends Grammar
{
    protected $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }
}
