<?php

use Controller\ProductController;
use Controller\UserController;

require_once './../Autoloader.php';
require_once './../App.php';
Autoloader::registrate();

    $app = new App();

    $app->get('/login', UserController::class, 'get_login');
    $app->post('/login', UserController::class, 'post_login', \Request\LoginRequest::class);

    $app->get('/registrate', UserController::class, 'getRegistrate');
    $app->post('/registrate', UserController::class, 'postRegistrate', \Request\RegistrateRequest::class);

    $app->get('/catalog', ProductController::class, 'getCatalog');

    $app->get('/cart', ProductController::class, 'getCart');

    $app->post('/plusProduct', ProductController::class, 'plusProduct');
    $app->post('/minusProduct', ProductController::class, 'minusProduct');

    $app->run();


