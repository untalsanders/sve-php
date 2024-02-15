<?php

declare(strict_types=1);

global $app;

use SVE\Controllers\HomeController;
use SVE\Controllers\AdminController;

// HomeController
$app->get('/', HomeController::class . ':init')->setName('user-home');
$app->post('/card', HomeController::class . ':card')->setName('user-card');

// AdminController
$app->get('/admin', AdminController::class . ':init')->setName('admin-home');
$app->post('/admin', AdminController::class . ':login')->setName('admin-login');
$app->redirect('/sign-out', '', 301);
