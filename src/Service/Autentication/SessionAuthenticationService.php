<?php

namespace Service\Autentication;

use Core\AuthenticationServiceInterface;
use Model\User;

class SessionAuthenticationService implements AuthenticationServiceInterface
{
    private User $user;
    public function startSession()
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
    }
    public function check(): bool
    {
        self::startSession();

        return isset($_SESSION['user_id']);
    }

    public function login(string $name, string $psw): bool
    {
        $obj = User::search($name, $psw);

        if (!$obj) {
            return  false;
        }

        self::startSession();
        $_SESSION['user_id'] = $obj->getId();
        $_SESSION['name'] = $obj->getName();

        return true;
    }

    public function getCurrentUser(): ?User
    {
        if(isset($this->user)){
            return $this->user;
        }

        if (!$this->check()){
             return null;
        }

        self::startSession();

        $userId = $_SESSION['user_id'];

        $this->user = User::getOneById($userId);

        return $this->user;

    }
}