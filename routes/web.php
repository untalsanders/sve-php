<?php

use App\Controllers\HomeController;

$app->get("/", HomeController::class . ':init')->setName('home');
$app->post("/tarjeton", HomeController::class . ':tarjeton')->setName('tarjeton');
