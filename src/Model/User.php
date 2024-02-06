<?php

namespace Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $phone;
    private string $psw;

    public function __construct(int $id, string $name, string $phone, string $psw)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->psw = $psw;
    }

    public static function search(string $name, string $psw):User
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM users WHERE name = :name and psw = :psw');

        $stmt->execute(['name' => $name, 'psw' => $psw]);
        $data = $stmt->fetch();
        return new User($data['id'], $data['name'], $data['phone'], $data['psw']);
    }

    public static function create(string $name, string $phone, string $psw) {

        $stmt = self::getPDO()->prepare('INSERT INTO users (name, phone, psw) values (:name, :phone, :psw)'); //защита от некоректных данных
        $stmt->execute(['name' => $name, 'phone' => $phone, 'psw' => $psw]); //экранирование данных
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getPsw(): string
    {
        return $this->psw;
    }
}