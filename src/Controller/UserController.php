<?php

namespace Controller;
use Model\User;

class UserController
{
    public function getRegistrate()
    {
        require_once './../View/get_registrate.phtml';
    }

    public function get_login()
    {
        require_once './../View/get_login.html';
    }

    public function postRegistrate()
    {
        $errors = [];

        $errors = $this->validate($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $psw = $_POST['psw'];


            User::create($name, $phone, $psw);

            header('location: /login');

        }
        else {
            print_r($errors);
            echo "Данные не добавлены";
        }

        require_once './../View/get_registrate.phtml';
    }

    public function post_login()
    {
        $name = $_POST['name'];
        $psw = $_POST['psw'];

        try {


            $obj = User::search($name, $psw);

            if (!empty($obj)) {
                session_start();
                $_SESSION['id'] = $obj->getId();
                $_SESSION['name'] = $obj->getName();
                header('location: /catalog');

            }
            else {
                echo "Неверный password или name";
            }

        }
        catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }

    }
    private function validate(array $data): array
    {
        $error = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (empty($name)) {
                $error['name'] = 'Имя должно быть заполнено';
            }
            elseif (strlen($name) < 2) {
                $error['name'] = 'Имя должно быть 2 символов';
            }

        }
        else {
            $error['name'] = 'Поле name не указано';
        }

        if (isset($data['phone'])) {
            $phone = $data['phone'];
            if (empty($phone)) {
                $error['phone'] = 'телефон должно быть заполнено';
            } elseif (strlen($phone) < 2) {
                $error['phone'] = 'Введите телефон правильно';
            }
        }
        else {
            $error['phone'] = 'Поле телефон не указано';
        }

        if (isset($data['psw'])) {
            $psw = $data['psw'];
            if (empty($psw)) {
                $error['psw'] = 'Password должно быть заполнено';
            }
            elseif (strlen($psw) < 2) {
                $error['psw'] = 'Введите password правильно';
            }

        }
        else {
            $error['psw'] = 'Поле password не указано';
        }

        return $error;
    }
}