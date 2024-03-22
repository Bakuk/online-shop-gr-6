<?php

use Controller\CartController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Core\App;
use Core\Autoloader;


require_once './../Core/Autoloader.php';
require_once './../Core/App.php';

Autoloader::registrate();

$container = new \Core\Container\Container();

$container->set(UserController::class, function () {
    $authentication = new Service\Autentication\SessionAuthenticationService();
    $viewRender = new Core\ViewRenderer();
    return new UserController($authentication, $viewRender);
});

$container->set(ProductController::class, function () {
    $authentication = new Service\Autentication\SessionAuthenticationService();
    $cartService = new \Service\CartService();
    $viewRenderer = new Core\ViewRenderer();
    return new ProductController($authentication, $cartService, $viewRenderer);
});

$container->set(OrderController::class, function () {
    $authentication = new Service\Autentication\SessionAuthenticationService();
    $orderService = new \Service\OrderService();
    $viewRenderer = new Core\ViewRenderer();
    return new OrderController($authentication, $orderService, $viewRenderer);
});

$container->set(CartController::class, function () {
    $authentication = new Service\Autentication\SessionAuthenticationService();
    $cartService = new \Service\CartService();
    $viewRenderer = new Core\ViewRenderer();
    return new CartController($authentication, $cartService,  $viewRenderer);
});

$container->set(PDO::class, function () {
    $host = getenv('DB_HOST');
    $dbName = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');

    return new PDO("pgsql:host=$host;port=5432;dbname=$dbName", $user, $password);
});



$app = new App($container);

$app->get('/login', UserController::class, 'get_login');
$app->post('/login', UserController::class, 'post_login', \Request\LoginRequest::class);

$app->get('/registrate', UserController::class, 'getRegistrate');
$app->post('/registrate', UserController::class, 'postRegistrate', \Request\RegistrateRequest::class);

$app->get('/catalog', ProductController::class, 'getCatalog');

$app->get('/cart', CartController::class, 'getCart');

$app->post('/plusProduct', ProductController::class, 'plusProduct', \Request\PlusProductRequest::class);
$app->post('/minusProduct', ProductController::class, 'minusProduct', \Request\MinusProductRequest::class);

$app->get('/order', OrderController::class, 'getOrder');
$app->post('/order', OrderController::class, 'postOrder', \Request\OrderRequest::class);

$app->get('/api/users', \Controller\Api\UserController::class, 'index');
$app->post('/api/users', \Controller\Api\UserController::class, 'create', \Request\Api\CreateUserRequest::class);

$app->run();


