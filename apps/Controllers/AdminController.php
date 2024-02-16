<?php

namespace SVE\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SVE\Core\Classes\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function home($request, $response, array $args)
    {
        return $this->view($response, "admin/home.twig", []);
    }
}
