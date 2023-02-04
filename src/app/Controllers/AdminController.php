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

        return $this->render($response, "admin/home.twig", [
            "administrador" => $administrador,
        ]);
    }
}
