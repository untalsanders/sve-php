<?php

declare(strict_types=1);

use DI\Container;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use SVE\Core\Classes\Database;
use Dotenv\Dotenv;
use Slim\Views\TwigMiddleware;

require ROOT_PATH . '/vendor/autoload.php';

$container = new Container();

$container->set('config', function () {
    return Dotenv::createImmutable(ROOT_PATH)->load();
});

$container->set('db', function () {
    return Database::getInstance()->connect();
});

$container->set('view', function () {
    return Twig::create(ROOT_PATH . '/resources/views', ['cache' => false]);
});

AppFactory::setContainer($container);
$app = AppFactory::create();
/* Display Errors */
$app->addErrorMiddleware(true, true, true);
$app->add(TwigMiddleware::createFromContainer($app));

require ROOT_PATH . '/routes/web.php';

return $app;


