<?php

namespace SVE\Core\Classes;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use SVE\Core\Traits\Singleton;
use Dotenv\Dotenv;

/**
 * Manage the connection to the database
 */
class Database
{
    /**
     * Provide the functionality to use the singleton pattern
     */
    use Singleton;

    /**
     * Connect to the database
     *
     * @return Connection \Doctrine\DBAL\Connection
     * @throws Exception
     */
    public function connect(): Connection
    {
        Dotenv::createImmutable(ROOT_PATH)->load();
        $config = new Configuration();

        $connectionParams = array(
            'dbname'   => $_ENV['DB_NAME'],
            'user'     => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'host'     => $_ENV['DB_HOST'],
            'port'     => $_ENV['DB_PORT'],
            'driver'   => $_ENV['DB_DRIVER'],
        );

        return DriverManager::getConnection($connectionParams, $config);
    }
}
