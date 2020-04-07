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

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

require APP_ROOT . "/vendor/autoload.php";

$app = AppFactory::create();

$app->addErrorMiddleware(true, true, false);

$app->get('/', function (Request $request, Response $response, array $args) {
    $payload = json_encode(['hello' => 'world'], JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

// $container = $app->getContainer();

// $container["db"] = function ($container) {
//     $db = \App\Core\Classes\Database::getInstance();
//     return $db->connect();
// };

// $container["view"] = function ($container) {
//     $view = new \Slim\Views\Twig(APP_ROOT . "/resources/views", [
//         "cache" => false
//     ]);

//     $view->addExtension(
//         new \Slim\Views\TwigExtension(
//             $container->router,
//             $container->request->getUri()
//         )
//     );

//     return $view;
// };

// require_once APP_ROOT . "/routes/web.php";
