<?php

namespace Waitmoonman\Database;

use Closure;
use PDOException;
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

    public static function beginTransaction(Closure $closure = null, Closure $rollBack = null)
    {
       self::getPdo()->beginTransaction();

        if ($closure instanceof Closure) {
            try {
                $closure();
                self::commit();
            } catch (PDOException $e) {
                self::rollBack();
                $rollBack($e);
            }
        }
    }

    public static function commit()
    {
        self::getPdo()->commit();
    }

    public static function rollBack()
    {
        self::getPdo()->rollBack();
    }

    public static function table($table)
    {
        self::checkConnect();

        return (
            new Builder(
                self::getPdo()
            )
        )->table($table);
    }

    public static function getPdo()
    {
        $instance = self::getInstance();
        return $instance->dbh;
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
