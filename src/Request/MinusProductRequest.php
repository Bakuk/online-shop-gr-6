<?php

namespace Request;

use Core\src\Request\Request;

class MinusProductRequest extends Request
{
    public function getMinus(): string
    {
        return $this->body['minus'];
    }
    public function getId(): string
    {
        return $this->body['product-id'];
    }
}