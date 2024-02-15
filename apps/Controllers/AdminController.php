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
    public function init($request, $response, array $args)
    {
        return $this->view($response, "admin/login.twig", []);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function login($request, $response, array $args)
    {
        $sql = "SELECT id, nombres, apellidos FROM administradores WHERE usuario = ? AND password = ?";
        $user = $request->getParsedBody()['user'];
        $password = $request->getParsedBody()['password'];
        $admin = $this->db()->fetchAssoc($sql, [$user, md5($password)]);

        // setcookie("SVECookie", md5($admin['id'] . $admin['nombres']), time() + 3600);

        return $this->view($response, "admin/home.twig", [
            "admin" => $admin,
        ]);
    }

    public function logout($request, $response, array $args)
    {
        setcookie("SVECookie", "", time() - 3600);
        return $app->redirect('/admin');
    }
}
