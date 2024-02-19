<?php

class App
{
    private array $routes = [];

    public function run()
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            if (isset($this->routes[$requestUri][$requestMethod])) {
                $handler = $this->routes[$requestUri][$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];
                $requestRoute = $handler['request'];

                $obj = new $class;

                if(empty($requestRoute)){
                    $request = new \Request\Request($requestMethod, $requestUri, headers_list(), $_REQUEST);
                    $obj->$method($request);
                } else {
                    $request = new $requestRoute($requestMethod, $requestUri, headers_list(), $_REQUEST);
                    $obj->$method($request);
                }

            } else {
                echo "Такого метода не существует";
            }
        } else {
            echo "неправильный uri";
        }

    }


    public function get(string $url, string $class, string $methodName, string $request = null): void
    {
        $this->routes[$url]['GET'] = [
            'class' => $class,
            'method' => $methodName,
            'request' => $request
        ];


    }

    public function post(string $url, string $class, string $methodName, string $request = null): void
    {
        $this->routes[$url]['POST'] = [
            'class' => $class,
            'method' => $methodName,
            'request' => $request
        ];

    }
}