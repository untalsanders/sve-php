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
        // Datos de la institucion
        $sqlInstitucion = "SELECT * FROM general WHERE activo = ?";
        $institucion = $this->container->get('db')->fetchAssoc($sqlInstitucion, ["S"]);

        // Datos del estudiante
        $sqlEstudiante = "SELECT * FROM estudiantes WHERE documento = ?";
        $estudiante = $this->container->get('db')->fetchAssoc($sqlEstudiante, [$request->getParsedBody()['dni']]);

        // Datos de los candidatos
        $sqlCategorias = "SELECT * FROM categorias";
        $categorias = $this->container->get('db')->query($sqlCategorias);

        $sqlCandidato = "SELECT t1.nombres, t1.apellidos, t1.representante FROM candidatos AS t1 INNER JOIN categorias as t2 ON t1.representante = t2.id";
        $stmt = $this->container->get('db')->prepare($sqlCandidato);
        $stmt->execute();
        $candidatos = $stmt->fetchAll();

        $appName = $this->container->get('config')['APP_NAME'];

        return $this->container->get('view')->render($response, "home/tarjeton.twig", [
            "titlePage" => 'Tarjetón',
            "estudiante" => $estudiante,
            "institucion" => $institucion,
            "categorias" => $categorias,
            "appName" => $appName,
            "candidatos" => $candidatos
        ]);
    }
}
