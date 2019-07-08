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
require APP_ROOT . "/vendor/autoload.php";

$app = new \Slim\App([
    "settings" => [
        "defaultErrorDetails" => true,
        "addContentLengthHeader" => false
    ]
]);

$container = $app->getContainer();

$container["db"] = function ($container) {
    $db = \App\Core\Classes\Database::getInstance();
    return $db->connect();
};

$container["view"] = function ($container) {
    $view = new \Slim\Views\Twig(APP_ROOT . "/resources/views", [
        "cache" => false
    ]);

    $view->addExtension(
        new \Slim\Views\TwigExtension(
            $container->router,
            $container->request->getUri()
        )
    );

    return $view;
};

require_once APP_ROOT . "/routes/web.php";
