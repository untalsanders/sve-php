<?php

declare(strict_types=1);

use DI\Container;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use SVE\Core\Classes\Database;
use Dotenv\Dotenv;
use Slim\Views\TwigMiddleware;

require APP_ROOT . '/../vendor/autoload.php';

// echo "<pre>";
// print_r(get_required_files());
// echo "</pre>";

// exit();

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

/* Display Errors */
$app->addErrorMiddleware(true, false, false);

$container->set('config', function () {
    return Dotenv::createImmutable(APP_ROOT . '/../')->load();
});

$container->set('db', function () {
    return Database::getInstance()->connect();
});

$container->set('view', function () {
    return Twig::create(APP_ROOT . '/resources/views', ['cache' => false]);
});

$app->add(TwigMiddleware::createFromContainer($app));

require APP_ROOT . '/routes/web.php';

return $app;


