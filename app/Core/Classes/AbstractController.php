<?php

namespace App\Core\Classes;

use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getAppName()
    {
        return $this->container->get('config')['APP_NAME'];
    }

    public function render($response, string $template, array $args = []) {
        return $this->container->get('view')->render($response, $template, $args);
    }
}
