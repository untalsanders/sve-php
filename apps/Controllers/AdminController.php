<?php

namespace SVE\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SVE\Core\Classes\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function home(Request $request, Response $response, array $args)
    {
        $sql = "SELECT t1.username, t1.email, t2.role_name, t3.meta_key, t3.meta_value
                FROM users t1
                LEFT JOIN roles t2 ON t1.role_id = t2.id
                LEFT JOIN meta_user t3 ON t1.id = t3.user_id
                WHERE username = ? AND password = ?";

        $username = $request->getParsedBody()['username'];
        $password = $request->getParsedBody()['password'];
        $user = $this->db()->fetchAssoc($sql, [$username, md5($password)]);

        return $this->view($response, 'admin/home.twig', ['user' => $user]);
    }

    public function foo(Request $request, Response $response, array $args)
    {
        $sql = "SELECT * FROM grades";
        $grades = $this->db()->fetchAll($sql);
        $body = $response->getBody();
        $body->write(json_encode($grades));
        return $response;
    }
}
