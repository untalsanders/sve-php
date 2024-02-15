<?php

namespace SVE\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SVE\Core\Classes\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function init(Request $request, Response $response, array $args)
    {
        $sql = 'SELECT * FROM general WHERE activo = ?';
        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(1, 'S');
        $stmt->execute();

        return $this->view($response, 'home/home.twig', [
            'pageTitle' => 'Inicio',
            'institute' => $stmt->fetch(),
            'appName' => $this->getAppName(),
        ]);
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function card(Request $request, Response $response, array $args)
    {
        // Datos de la institucion
        $queryInstitucion = 'SELECT * FROM general WHERE activo = ?';
        $institucion = $this->db()->fetchAssoc($queryInstitucion, ['S']);

        // Datos del estudiante
        $queryEstudiante = 'SELECT * FROM estudiantes WHERE documento = ?';
        $estudiante = $this->db()->fetchAssoc($queryEstudiante, [$request->getParsedBody()['documento']]);

        // Datos de las categorías
        $queryCategoria = 'SELECT * FROM categorias';
        $categorias = $this->db()->query($queryCategoria);

        // Datos de los candidatos
        $queryCandidatos = 'SELECT t2.nombres, t2.apellidos FROM candidatos AS t1 LEFT JOIN estudiantes as t2 ON t1.representante = t2.id';
        $candidatos = $this->db()->query($queryCandidatos);

        return $this->view($response, 'home/card.twig', [
            'ageTitle'   => 'Tarjetón',
            'estudiante'  => $estudiante,
            'institucion' => $institucion,
            'categorias'  => $categorias,
            'candidatos'  => $candidatos,
        ]);
    }
}
