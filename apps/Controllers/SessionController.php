<?php

namespace SVE\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SVE\Core\Classes\AbstractController;

class SessionController extends AbstractController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function login(Request $request, Response $response, array $args)
    {
        $sql = "SELECT t1.username, t1.email, t2.role_name FROM users t1 LEFT JOIN roles t2 ON t1.role_id = t2.id WHERE username = ? AND password = ?";
        $username = $request->getParsedBody()['username'];
        $password = $request->getParsedBody()['password'];
        $user = $this->db()->fetchAssoc($sql, [$username, md5($password)]);

        $view = $user['role_name'] == 'admin' ? "admin/home.twig" : "student/home.twig";

        return $this->view($response, $view, ["user" => $user]);
    }
}
