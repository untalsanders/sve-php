<?php

namespace App\Controllers;

use App\Core\Classes\Controller;

class HomeController extends Controller
{
    public function index($request, $response, $args)
    {
        $sql = "SELECT * FROM general";
        $result = $this->db->query($sql);
        $instituciones = array();

        while ($row = $result->fetch()) {
            $instituciones[] = $row;
        }

        return $this->view->render($response, "welcome.twig", ["instituciones" => $instituciones]);
    }
}
