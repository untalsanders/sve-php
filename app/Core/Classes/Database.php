<?php

namespace App\Core\Classes;

use App\Core\Traits\Singleton;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

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
        $config = new Configuration();

        $connectionParams = array(
            'dbname' => 'ses',
            'user' => 'sanders',
            'password' => '12345',
            'host' => 'localhost',
            'driver' => 'mysqli',
        );

        return DriverManager::getConnection($connectionParams, $config);
    }
}
