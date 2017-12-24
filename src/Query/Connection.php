<?php

namespace Waitmoonman\Database\Query;

use PDO;
use PDOException;
use Waitmoonman\Database\Exceptions\QueryException;

class Connection
{

    public function connect(array $config)
    {
        $dsn = $this->getDsn($config);

        return $this->createPdo($dsn, $config);
    }

    protected function getDsn(array $config)
    {
        extract($config, EXTR_SKIP);

        return isset($port)
            ? "mysql:host={$host};port={$port};dbname={$database}"
            : "mysql:host={$host};dbname={$database}";
    }

    protected function createPdo($dsn, array $config)
    {
        list($username, $password) = [
            $config['username'] ?: null, $config['password'] ?: null,
        ];

        try {
            return new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            throw new QueryException($e->getMessage());
        }

    }

}