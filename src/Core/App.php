<?php


namespace Core;

use Core\src\Container\Container;
use Core\src\Logger\LoggerService;
use PDO;
use Throwable;

class App
{
    private array $routes = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bootstrap()
    {
        $pdo = $this->container->get(PDO::class);
        src\Model\Model::init($pdo);
    }

    public function run()
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            if (isset($this->routes[$requestUri][$requestMethod])) {
                $handler = $this->routes[$requestUri][$requestMethod];
                $this->bootstrap();
                $class = $handler['class'];
                $method = $handler['method'];
                $requestRoute = $handler['request'];


                $obj = $this->container->get($class);


                if (empty($requestRoute)) {
                    $request = new src\Request\Request($requestMethod, $requestUri, headers_list(), $_REQUEST);
                } else {
                    $request = new $requestRoute($requestMethod, $requestUri, headers_list(), $_REQUEST);

                }

                try {

                    $response = $obj->$method($request);

                    echo $response;

                } catch (Throwable $exeption) {
                    LoggerService::error($exeption);
                    require_once './../View/500.html';
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