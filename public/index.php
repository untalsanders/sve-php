<?php

declare(strict_types=1);

/**
 * Sistema de Votación Electrónica
 *
 * @package  sve
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
 * Directory Separator
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Root directory of application
 */
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname($_SERVER['DOCUMENT_ROOT'], 1) . '/src');
}

/**
 * Bootstrap Application
 */
$app = require APP_ROOT . '/bootstrap/app.php';

$app->run();
