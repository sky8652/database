<?php

namespace Waitmoonman\Database\Foundation;


use Waitmoonman\Database\Contracts\DataBaseInterface;
use Waitmoonman\Database\Query\Builder;

class Insert extends Grammar
{
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }
}