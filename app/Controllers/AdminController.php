<?php

namespace SVE\Controllers;

use SVE\Core\Classes\AbstractController;

class AdminController extends AbstractController
{
    public function init($request, $response, array $argss)
    {
        return $this->render($response, "admin/login.twig", []);
    }

    public function login($request, $response, array $argss)
    {
        // Datos de l administrador
        $queryAdministrador = "SELECT id, nombres, apellidos FROM administrador WHERE usuario = ? AND contrasena = ?";
        $usuario = $request->getParsedBody()['usuario'];
        $contrasena = $request->getParsedBody()['contrasena'];
        $administrador = $this->container->get('db')->fetchAssoc($queryAdministrador, [$usuario, md5($contrasena)]);
        
        // setcookie("SVECookie", md5($administrador['id'] . $administrador['nombres']), time() + 3600);

        return $this->render($response, "admin/home.twig", [
            "administrador" => $administrador,
        ]);
    }

    public function logout($request, $response, array $argss)
    {
        setcookie("SVECookie", "", time() - 3600);
        return $app->redirect('/admin');
    }
}
