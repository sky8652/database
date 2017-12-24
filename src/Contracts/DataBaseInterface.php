<?php

namespace Waitmoonman\Database\Contracts;

use Waitmoonman\Database\Query\Builder;

interface DataBaseInterface
{
    public function toSql();
    public function build($param = []);
}