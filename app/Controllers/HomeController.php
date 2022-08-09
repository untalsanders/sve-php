<?php

namespace App\Controllers;

use App\Core\Classes\AbstractController;

class HomeController extends AbstractController
{
    public function init($request, $response, array $argss)
    {
        $sql = "SELECT * FROM general WHERE activo = ?";
        $stmt = $this->container->get('db')->prepare($sql);
        $stmt->bindValue(1, 'S');
        $stmt->execute();
        $instituciones = array();

        while ($row = $stmt->fetch()) {
            $instituciones[] = $row;
        }

        return $this->render($response, "home/home.twig", [
            "pageTitle"     => 'Inicio',
            "instituciones" => $instituciones,
            "appName"       => $this->getAppName(),
        ]);
    }

    public function tarjeton($request, $response, $args)
    {
        // Datos de la institucion
        $queryInstitucion = "SELECT * FROM general WHERE activo = ?";
        $institucion = $this->container->get('db')->fetchAssoc($queryInstitucion, ["S"]);

        // Datos del estudiante
        $queryEstudiante = "SELECT * FROM estudiantes WHERE dni = ?";
        $estudiante = $this->container->get('db')->fetchAssoc($queryEstudiante, [$request->getParsedBody()['dni']]);

        // Datos de los candidatos
        $queryCategorias = "SELECT * FROM categorias";
        $categorias = $this->container->get('db')->query($queryCategorias);

        $queryCandidato = "SELECT t1.nombres, t1.apellidos, t1.representante FROM candidatos AS t1 INNER JOIN categorias as t2 ON t1.representante = t2.id";
        $stmt = $this->container->get('db')->prepare($queryCandidato);
        $stmt->execute();
        $candidatos = $stmt->fetchAll();

        return $this->render($response, "home/tarjeton.twig", [
            "pageTitle"   => 'Tarjetón',
            "estudiante"  => $estudiante,
            "institucion" => $institucion,
            "categorias"  => $categorias,
            "appName"     => $this->getAppName(),
            "candidatos"  => $candidatos,
        ]);
    }
}
