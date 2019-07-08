<?php

namespace App\Controllers;

use App\Core\Classes\Controller;

class HomeController extends Controller
{
    public function index($request, $response, $args)
    {
        return $this->view->render($response, "welcome.twig", ["message" => "Hello World",]);
    }
}
