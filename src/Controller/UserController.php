<?php

namespace Controller;
use Core\AuthenticationServiceInterface;
use Core\ViewRenderer;
use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController
{
    private AuthenticationServiceInterface $authenticationService;
    private ViewRenderer $viewRenderer;
    public function __construct(AuthenticationServiceInterface $authenticationService, ViewRenderer $viewRenderer)
    {
        $this->authenticationService = new $authenticationService;
        $this->viewRenderer = new $viewRenderer;
    }
    public function getRegistrate():string
    {

        return $this->viewRenderer->render('get_registrate.phtml', []);
    }

    public function postRegistrate(RegistrateRequest $request):string
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

        return $this->viewRenderer->render('get_registrate.phtml', ['errors' => $errors]);

    }

    public function get_login()
    {
        return $this->viewRenderer->render('get_login.html', []);
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