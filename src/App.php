<?php


use Controller\ProductController;
use Controller\UserController;

require_once './../Autoloader.php';

Autoloader::registrate();

class App
{

    private array $routes = [
        '/login' => [
           'GET' => [
               'class' => UserController::class,
               'method' => 'get_login'
           ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'post_login'
            ]
        ],

        '/catalog' => [
            'GET' => [
                'class' => ProductController::class,
                'method' => 'getCatalog'
            ]
        ],

        '/registrate' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'postRegistrate'
            ]
        ],

        '/plusProduct' => [
            'POST' => [
                'class' => ProductController::class,
                'method' => 'plusProduct'
            ]
        ],

        '/minusProduct' => [
            'POST' => [
                'class' => ProductController::class,
                'method' => 'minusProduct'
            ]
        ],

        '/cart' => [
            'GET' => [
                'class' => ProductController::class,
                'method' => 'getCart'
            ]
        ]
    ];
    public function run()
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];


        if ($this->routes[$requestUri])
        {
            if ($this->routes[$requestUri][$requestMethod])
            {

                $obj = new $this->routes[$requestUri][$requestMethod]['class'];
                $method =  $this->routes[$requestUri][$requestMethod]['method'];
                $obj->$method();
            }
        }

    }
}