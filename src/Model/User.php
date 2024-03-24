<?php

namespace Model;

use Core\src\Model\Model;

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

    public static function search(string $name, string $psw): ?User
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM users WHERE name = :name and psw = :psw');

        $stmt->execute(['name' => $name, 'psw' => $psw]);
        $data = $stmt->fetch();
        if (!empty($data))
            return new User($data['id'], $data['name'], $data['phone'], $data['psw']);

        return null;

    }

    public static function getOneById(int $id): ?User
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM users WHERE id = :id ');

        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        if (!empty($data))
            return new User($data['id'], $data['name'], $data['phone'], $data['psw']);

        return null;

    }

    public static function create(string $name, string $phone, string $psw): void {

        $stmt = self::getPDO()->prepare('INSERT INTO users (name, phone, psw) values (:name, :phone, :psw)'); //защита от некоректных данных
        $stmt->execute(['name' => $name, 'phone' => $phone, 'psw' => $psw]);
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


    public static function all(): ?array
    {
        $sql = <<<SQL
            select *
            from users
        SQL;

        $stmt = self::getPDO()->query($sql);
        $users = $stmt->fetchAll();

        foreach ($users as $user) {
            $data[] = new User(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['password']
            );
        }

        if (empty($data)) {
            return null;
        }

        return $data;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}