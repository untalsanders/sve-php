<?php

namespace SVE\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use SVE\Core\Classes\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        return $this->view($response, "index.twig", []);
    }
}
