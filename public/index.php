<?php
/**
 * Electronic Electoral System
 *
 * @package  ees
 * @author   Sanders Gutiérrez <ing.sanders@gmail.com>
 */

declare(strict_types=1);

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
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

/**
 * Bootstrap Application
 */
$app = require ROOT_PATH . '/apps/bootstrap.php';

$app->run();
