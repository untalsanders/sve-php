<?php

namespace SVE\Core\Classes;

use SVE\Core\Traits\Singleton;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Dotenv\Dotenv;

/**
 * Gestiona la conexión a la base de datos
 */
class Database
{
    /**
     * Provee la funcionalidad para el uso del Patŕon Singleton
     */
    use Singleton;

    /**
     * Se conecta a la base de datos
     *
     * @return object \Doctrine\DBAL\DriverManager
     */
    public function connect()
    {
        Dotenv::createImmutable(APP_ROOT)->load();
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
