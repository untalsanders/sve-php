<?php

/**
 * Sistema Electoral Universitario
 *
 * @package  eduvota
 * @author   Sanders Gutiérrez <ing.sanders@gmail.com>
 */

if (PHP_SAPI !== 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

/**
 * Separador de Directorios
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Directorio Raíz de la Aplicación
 */
if (!defined('APP_ROOT')) {
    define('APP_ROOT', realpath($_SERVER['DOCUMENT_ROOT'] . '/../'));
}

/**
 * Bootstrap Applicacion
 */
require_once APP_ROOT . '/bootstrap/app.php';

$app->run();
