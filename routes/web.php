<?php

use SVE\Controllers\HomeController;
use SVE\Controllers\AdminController;

$app->get("/", HomeController::class . ':init')->setName('home');
$app->post("/tarjeton", HomeController::class . ':tarjeton')->setName('tarjeton');
$app->get("/admin", AdminController::class . ':init')->setName('admin');
$app->post("/admin", AdminController::class . ':login')->setName('admin');
$app->redirect('/salir', '/admin', 301);
