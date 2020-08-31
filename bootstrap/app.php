<?php

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so we do not have to manually load any of
| our application's PHP classes. It just feels great to relax.
|
*/

use DI\Container;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use App\Core\Classes\Database;
use Dotenv\Dotenv;
use Slim\Views\TwigMiddleware;

require APP_ROOT . "/vendor/autoload.php";

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

/* Display Errors */
$app->addErrorMiddleware(true, false, false);

$container->set("config", function () {
    return Dotenv::createImmutable(APP_ROOT)->load();
});

$container->set("db", function () {
    return Database::getInstance()->connect();
});

$container->set('view', function () {
    return Twig::create(APP_ROOT . "/resources/views", ['cache' => false]);
});

$app->add(TwigMiddleware::createFromContainer($app));

require_once APP_ROOT . "/routes/web.php";

return $app;
