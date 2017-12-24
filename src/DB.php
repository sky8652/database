<?php

namespace Waitmoonman\Database;

use Waitmoonman\Database\Contracts\DataBaseInterface;
use Waitmoonman\Database\Exceptions\QueryException;
use Waitmoonman\Database\Foundation\Connection;
use Waitmoonman\Database\Query\Builder;

class DB
{
    protected static $instance;
    protected $dbh;


    public static function addConnection(array $config)
    {
        $instance = self::getInstance();

        $instance->dbh = (new Connection)->connect($config);
    }

    public static function table($table)
    {
        self::checkConnect();

        $instance = self::getInstance();

        return (new Builder($instance->dbh))->table($table);
    }


    protected static function checkConnect()
    {
        $instance = self::getInstance();

        if (is_null($instance->dbh)) {
            throw new QueryException('请先配置数据库连接');
        }
    }


    protected static function getInstance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new self;
        }

        return self::$instance;
    }
}