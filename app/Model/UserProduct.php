<?php

require_once './../Model/Model.php';
class UserProduct extends Model
{
    public function create(int $userId, int $productId, int $quantity)
    {

        $stmt = $this->pdo->prepare('INSERT INTO user_products (user_id, product_id, quantity) values (:user_id, :product_id, :quantity)'); //защита от некоректных данных
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]); //экранирование данных
    }

    public function getAll(int $user_id):array
    {

        $stmt = $this->pdo->prepare('SELECT user_id, title, quantity, price, descr, pictures FROM user_products
                                                JOIN products
                                                    ON user_products.product_id=products.id
                                                    WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function count()
    {
        $stmt = $this->pdo->query('SELECT sum(quantity)
                                                FROM user_products
                                                    JOIN products
                                                        ON user_products.product_id=products.id;');


        return $stmt->fetch();
    }
}