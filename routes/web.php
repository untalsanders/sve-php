<?php

use App\Controllers\HomeController;

$app->get("/", HomeController::class . ':home');
$app->post("/tarjeton", HomeController::class . ':tarjeton');
