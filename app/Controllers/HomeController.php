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
}
