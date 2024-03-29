<?php

namespace Core;
class Autoloader
{
    public static function registrate()
    {
        $autoloader = function (string $class): bool {
            $file = './../' . str_replace('\\', '/', $class) . '.php';

            if (file_exists($file)) {
                require_once $file;
                return true;
            }
            return false;
        };


        spl_autoload_register($autoloader);
    }
}