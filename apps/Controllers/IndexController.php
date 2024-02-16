<?php

namespace SVE\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SVE\Core\Classes\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function index(Request $request, Response $response, array $args)
    {
        return $this->view($response, "index.twig", []);
    }
}
