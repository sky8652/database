<?php

namespace Waitmoonman\Database;

use Waitmoonman\Database\Exceptions\QueryException;
use Waitmoonman\Database\Schema\Builder;
use Waitmoonman\Database\Schema\Connection;

class DB
{
    protected static $instance;
    protected static $connectFlag = false;
    protected $dbh;

    public static function addConnection(array $config)
    {
        $instance = self::getInstance();

        $instance->dbh = (new Connection())->connect($config);

        self::$connectFlag = true;
    }

    public static function table($table)
    {
        self::checkConnect();

        $instance = self::getInstance();

        return (new Builder($instance->dbh))->table($table);
    }

    protected static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    protected static function checkConnect()
    {
        if (! self::$connectFlag) {
            throw new QueryException('请先配置数据库连接');
        }
    }
}
