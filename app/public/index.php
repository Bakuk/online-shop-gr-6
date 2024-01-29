<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

require_once './../Controller/UserController.php';
require_once './../Controller/ProductController.php';

if ($requestUri == '/login'){
    if ($requestMethod == 'GET'){

        $obj = new UserController();
        $obj->get_login();
    } elseif ($requestMethod == 'POST'){
        $obj = new UserController();
        $obj->post_login();
    } else {
        echo "Метод $requestMethod не поддерживает для адреса $requestUri";
    }

}elseif ($requestUri == '/catalog'){
    if ($requestMethod == 'GET'){
        $obj = new ProductController();
        $obj->getCatalog();
    }
} elseif ($requestUri == '/registrate'){
    if ($requestMethod == 'GET'){

        $obj = new UserController();
        $obj->getRegistrate();
    } elseif ($requestMethod == 'POST'){
        $obj = new UserController();
        $obj->postRegistrate();
    } else {
        echo "Метод $requestMethod не поддерживает для адреса $requestUri";
    }
} elseif ($requestUri == '/add-product'){
    if ($requestMethod == "POST"){
        $obj = new ProductController();
        $obj->addProduct();
    }
} elseif ($requestUri == '/cart'){
    if ($requestMethod == "GET"){
        $obj = new ProductController();
        $obj->getCart();
    }
} else {
    require_once './../View/404.html';
}

