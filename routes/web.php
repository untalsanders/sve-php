<?php

declare(strict_types=1);

global $app;

use SVE\Controllers\StudentController;
use SVE\Controllers\AdminController;
use SVE\Controllers\IndexController;
use SVE\Controllers\SessionController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Index
$app->get('/', IndexController::class . ':index')->setName('index');
// Login
$app->post('/', SessionController::class . ':login')->setName('login');
// Logout
$app->redirect('/logout', '/', 301);

// HomeController
$app->get('/student', StudentController::class . ':index')->setName('student-index');
$app->post('/student/card', StudentController::class . ':card')->setName('student-card');

// AdminController
$app->get('/admin', AdminController::class . ':home')->setName('admin-home');

$app->get('/foo', AdminController::class . ':foo')->setName('foo')->add($jsonMiddleware);
