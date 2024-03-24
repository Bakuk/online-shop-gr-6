<?php

namespace Service\Autentication;

use Core\AuthenticationServiceInterface;
use Model\User;

class CookieAuthenticationService implements AuthenticationServiceInterface
{
    public function check()
    {
        return isset($_COOKIE['user_id']);
    }

    public function setUser(int $user_id):void
    {
        setcookie('user_id', $user_id);

    }

    public function getCurrentUser(): ?User
    {
        if(isset($this->user)){
            return $this->user;
        }

        if (!$this->check()){
            return null;
        }

        $userId = $_SESSION['user_id'];

        $this->user = User::getOneById($userId);

        return $this->user;

    }
}