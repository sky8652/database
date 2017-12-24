<?php

namespace Waitmoonman\Database\Foundation;



use Waitmoonman\Database\Query\Builder;

class Update extends Grammar
{
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }
}