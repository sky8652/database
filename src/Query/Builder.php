<?php

namespace Waitmoonman\Database\Query;

use PDO;

class Builder
{
    protected $dbh;

    public function __construct($dbh)
    {
        $this->dbh = $dbh;
    }

    public function table($table)
    {

        return $this;
    }
}