<?php

namespace Service;

use Model\User;

class SessionAuthenticationService
{
    public function check(): bool
    {
        $this->start();

        return isset($_SESSION['user_id']);
    }

    public function login(string $name, string $psw): bool
    {
        $obj = User::search($name, $psw);

        if (!$obj) {
            return  false;
        }

        $this->start();
        $_SESSION['id'] = $obj->getId();
        $_SESSION['name'] = $obj->getName();

        return true;
    }

    public function getCurrentUser(): ?User
    {
        if (!$this->check()){
            return null;
        }

        $this->start();

        $userId = $_SESSION['user_id'];

        return User::getOneById($userId);

    }


    public function start()
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

}