<?php

namespace Request;

use Core\src\Request\Request;

class PlusProductRequest extends Request
{
    public function getPlus(): string
    {
        return $this->body['plus'];
    }
    public function getId(): string
    {
        return $this->body['product-id'];
    }

}