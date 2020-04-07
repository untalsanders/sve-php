<?php

namespace App\Controllers;

use App\Core\Classes\Controller;

class HomeController extends Controller
{
    public function index($request, $response, $args)
    {
        $sql = "SELECT * FROM general WHERE activo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, 'S');
        $stmt->execute();
        $instituciones = array();

        while ($row = $stmt->fetch()) {
            $instituciones[] = $row;
        }

        return $this->view->render($response, "home/home.twig", ["instituciones" => $instituciones]);
    }

    public function tarjeton($request, $response, $args)
    {
        $sqlEstudiante = "SELECT * FROM estudiantes WHERE documento = ?";
        $estudiante = $this->db->fetchAssoc($sqlEstudiante, [$request->getParsedBody()['dni']]);

        $sqlInstitucion = "SELECT * FROM general WHERE activo = ?";
        $institucion = $this->db->fetchAssoc($sqlInstitucion, ["S"]);

        $sqlCategorias = "SELECT * FROM categorias";
        $categorias = $this->db->query($sqlCategorias);

        // $sqlCandidato = "SELECT * FROM candidatos WHERE representante = $categorias";

        return $this->view->render($response, "home/tarjeton.twig", [
            "estudiante" => $estudiante,
            "institucion" => $institucion,
            "categorias" => $categorias
        ]);
    }
}
