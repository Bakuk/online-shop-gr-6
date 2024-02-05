<?php

class Autoloader
{
    public static function registrate()
    {
        $autloader = function (string $class){
            //$class = Controller\UserController
            // /var/www/html/src/Controller/UserController.php
            $path = str_replace('\\', '/', $class); // Controller/UserController
            $path = $path . ".php"; // Controller/UserController.php
            $path = __DIR__ ."/". $path; // /var/www/html/src/Controller/UserController.php
            //echo ($path);

 
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
            return false;
        };


        spl_autoload_register($autloader);
    }
}