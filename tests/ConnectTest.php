<?php

namespace Tests;

use PDO;
use PHPUnit\Framework\TestCase;
use Waitmoonman\Database\Schema\Connection;

class ConnectTest extends TestCase
{
    public function testConnect()
    {
        $config = require_once __DIR__ . '/../config/database.php';

        $dbh = (new Connection())->connect($config);

        $this->assertInstanceOf(PDO::class, $dbh);

        return $dbh;
    }
}