<?php

namespace Core;

class Container
{
    private array $services;

    public function set(string $class, callable $callback)
    {
        $this->services[$class] = $callback;
    }

    public function get(string $class): object
    {
        if (isset($this->services[$class])){
            $callback = $this->services[$class];

            $result = $callback();

            return $result;
        }

        return new $class();
    }
}