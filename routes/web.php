<?php

use App\Controllers\HomeController;

$app->get("/", HomeController::class . ':index');
$app->post("/tarjeton", HomeController::class . ':tarjeton');
