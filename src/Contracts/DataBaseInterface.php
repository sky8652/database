<?php

namespace Waitmoonman\Database\Contracts;

interface DataBaseInterface
{
    public function toSql();

    public function build($param = []);
}
