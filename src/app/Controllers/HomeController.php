<?php

namespace SVE\Controllers;

use SVE\Core\Classes\AbstractController;

class HomeController extends AbstractController
{
    public function init($request, $response, array $argss)
    {
        $sql = "SELECT * FROM institucion WHERE activo = ?";
        $stmt = $this->container->get('db')->prepare($sql);
        $stmt->bindValue(1, 'S');
        $stmt->execute();

        return $this->render($response, "home/home.twig", [
            "pageTitle" => 'Inicio',
            "institucion" => $stmt->fetch(),
            "appName" => $this->getAppName(),
        ]);
    }

    public function tarjeton($request, $response, $args)
    {
        // Datos de la institucion
        $queryInstitucion = "SELECT * FROM institucion WHERE activo = ?";
        $institucion = $this->container->get('db')->fetchAssoc($queryInstitucion, ["S"]);

        // Datos del estudiante
        $queryEstudiante = "SELECT * FROM estudiante WHERE documento = ?";
        $estudiante = $this->container->get('db')->fetchAssoc($queryEstudiante, [$request->getParsedBody()['documento']]);

        // Datos de los candidatos
        $queryCategoria = "SELECT * FROM categoria";
        $categorias = $this->container->get('db')->query($queryCategoria);

        $queryCandidatos = "SELECT t2.nombres, t2.apellidos FROM candidato AS t1 LEFT JOIN estudiante as t2 ON t1.estudiante_id = t2.id";
        $stmt = $this->container->get('db')->prepare($queryCandidatos);
        $stmt->execute();
        $candidatos = $stmt->fetchAll();

        return $this->render($response, "home/tarjeton.twig", [
            "pageTitle"   => 'Tarjetón',
            "estudiante"  => $estudiante,
            "institucion" => $institucion,
            "categorias"  => $categorias,
            "candidatos"  => $candidatos,
        ]);
    }
}
