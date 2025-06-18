<?php

declare(strict_types=1);

use DI\Container;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use SVE\Core\Classes\Database;
use Dotenv\Dotenv;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

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
$app = AppFactory::createFromContainer($container);

$jsonMiddleware = function (Request $request, Response $response, callable $next) {
    $response = $next($request, $response);
    $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($response->getBody()->getContents(), JSON_PRETTY_PRINT));
    return $response;
};

/* Routing Middleware */
$app->addRoutingMiddleware();

/* Errors Middleware */
$app->addErrorMiddleware(true, true, true);

/* Twig Middleware */
$app->add(TwigMiddleware::createFromContainer($app));

/* Routes */
require ROOT_PATH . '/routes/web.php';

return $app;
