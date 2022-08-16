<?php

/**
 * Funcionar para conectarse a la base de datos
 *
 * @return MySQLi $link
 */
if (!function_exists('conectarse')) {
    function conectarse()
    {
        /*
         * Host BD al que conectarse, habitualmente es localhost
         */
        $db_host = "127.0.0.1";
        /*
         * Port BD al que conectarse, habitualmente es 3306
         */
        $db_port = 3307;
        /*
         * Nombre de la Base de Datos que se desea utilizar
         */
        $db_nombre = "ses";
        /*
         * Nombre del usuario con permisos para acceder a la BD
         */
        $db_user = "root";
        /*
         * Contraseña del usuario de la BD
         */
        $db_pass = "12345";
        /*
         * Ahora estamos realizando una conexi�n y la llamamos $link
         */
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_nombre, $db_port)
            or die("Error conectando a la base de datos.");
        /*
         * Retornamos $link  para hacer consultas a la BD.
         */
        return $conn;
    }
}
