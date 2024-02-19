<?php

namespace Controller;
use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Request\Request;
use Service\SessionAuthenticationService;

class UserController
{
    private SessionAuthenticationService $authenticationService;
    public function __construct()
    {
        $this->authenticationService = new SessionAuthenticationService();
    }
    public function getRegistrate()
    {
        require_once './../View/get_registrate.phtml';
    }

    public function get_login()
    {
        require_once './../View/get_login.html';
    }

    public function postRegistrate(RegistrateRequest $request)
    {

        $errors = [];

        $errors = $request->validate($_POST);

        if (empty($errors)) {
            $name = $request->getName();
            $phone = $request->getPhone();
            $psw = $request->getPsw();


            User::create($name, $phone, $psw);

            header('location: /login');

        }
        else {
            print_r($errors);
            echo "Данные не добавлены";
        }

        require_once './../View/get_registrate.phtml';
    }

    public function post_login(LoginRequest $request)
    {
        $name = $request->getName();
        $psw = $request->getPsw();

        try {

            $result = $this->authenticationService->login($name, $psw);

            if ($result) {
                header('location: /catalog');

            }
            echo "Неверный password или name";

        }
        catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }

    }
}