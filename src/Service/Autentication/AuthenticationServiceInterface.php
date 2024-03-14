<?php

namespace Service\Autentication;
use Model\User;

interface AuthenticationServiceInterface
{
    public function check(): bool;

    public function login(string $name, string $psw): bool;

    public function getCurrentUser(): ?User;
}