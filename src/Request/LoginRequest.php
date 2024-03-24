<?php

namespace Request;

use Core\src\Request\Request;

class LoginRequest extends Request
{
    public function getName(): string
    {
        return $this->body['name'];
    }
    public function getPsw(): string
    {
        return $this->body['psw'];
    }
}