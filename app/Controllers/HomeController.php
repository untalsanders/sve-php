<?php

namespace App\Controllers;

use App\Core\Classes\Controller;

class HomeController extends Controller
{
    public function home($request, $response, array $argss)
    {
        $sql = "SELECT * FROM general WHERE activo = ?";
        $stmt = $this->container->get('db')->prepare($sql);
        $stmt->bindValue(1, 'S');
        $stmt->execute();
        $instituciones = array();

        while ($row = $stmt->fetch()) {
            $instituciones[] = $row;
        }

        $appName = $this->container->get('config')['APP_NAME'];

        return $this->container->get('view')->render($response, "home/home.twig", [
            "titlePage" => 'Home',
            "instituciones" => $instituciones,
            "appName" => $appName
        ]);
    }

    public function tarjeton($request, $response, $args)
    {
        $sqlEstudiante = "SELECT * FROM estudiantes WHERE documento = ?";
        $estudiante = $this->container->get('db')->fetchAssoc($sqlEstudiante, [$request->getParsedBody()['dni']]);

        $sqlInstitucion = "SELECT * FROM general WHERE activo = ?";
        $institucion = $this->container->get('db')->fetchAssoc($sqlInstitucion, ["S"]);

        $sqlCategorias = "SELECT * FROM categorias";
        $categorias = $this->container->get('db')->query($sqlCategorias);

        // $sqlCandidato = "SELECT * FROM candidatos WHERE representante = $categorias";

        return $this->container->get('view')->render($response, "home/tarjeton.twig", [
            "estudiante" => $estudiante,
            "institucion" => $institucion,
            "categorias" => $categorias
        ]);
    }
}
