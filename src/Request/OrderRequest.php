<?php

namespace Request;

class OrderRequest extends Request
{
    public function getName(): string
    {
        return $this->body['name'];
    }

    public function getPhone(): string
    {
        return $this->body['phone'];
    }

    public function getAddress(): string
    {
        return $this->body['address'];
    }
    public function getComment(): string
    {
        return $this->body['comment'];
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

        if (isset($userInfo['address'])) {
            $address = $userInfo['address'];
            if (empty($address)) {
                $error['address'] = 'Address должно быть заполнено';
            }
            elseif (strlen($address) < 2) {
                $error['address'] = 'Введите address правильно';
            }

        }
        else {
            $error['psw'] = 'Поле address не указано';
        }

        return $error;
    }
}