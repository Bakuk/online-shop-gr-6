<?php

require_once './../Model/Model.php';

class User extends Model
{
    public function search(string $name, string $psw):array
    {

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE name = :name and psw = :psw');

        $stmt->execute(['name' => $name, 'psw' => $psw]);
        $data = $stmt->fetch();

        return $data;
    }
    public function create(string $name, string $phone, string $psw)
    {

        $stmt = $this->pdo->prepare('INSERT INTO users (name, phone, psw) values (:name, :phone, :psw)'); //защита от некоректных данных
        $stmt->execute(['name' => $name, 'phone' => $phone, 'psw' => $psw]); //экранирование данных
    }
}