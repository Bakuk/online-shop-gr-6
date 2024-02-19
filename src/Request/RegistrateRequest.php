<?php

namespace Request;

class RegistrateRequest extends Request
{

    public function getName(): string
    {
        return $this->body['name'];
    }

    public function getPhone(): string
    {
        return $this->body['phone'];
    }

    public function getPsw(): string
    {
        return $this->body['psw'];
    }


    public function validate(array $userInfo):array
    {
        $error = [];

        if (isset($userInfo['name'])) {
            $name = $userInfo['name'];
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

        if (isset($userInfo['phone'])) {
            $phone = $userInfo['phone'];
            if (empty($phone)) {
                $error['phone'] = 'телефон должно быть заполнено';
            } elseif (strlen($phone) < 2) {
                $error['phone'] = 'Введите телефон правильно';
            }
        }
        else {
            $error['phone'] = 'Поле телефон не указано';
        }

        if (isset($userInfo['psw'])) {
            $psw = $userInfo['psw'];
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