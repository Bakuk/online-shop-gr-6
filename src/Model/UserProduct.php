<?php

namespace Model;

class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $quantity;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity():int
    {
        return $this->quantity;
    }

    public function __construct(int $id, int $userId, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
    public static function create(int $userId, int $productId, int $quantity)
    {
        $stmt = self::getPDO()->prepare('INSERT INTO user_products (user_id, product_id, quantity) values (:user_id, :product_id, :quantity)'); //защита от некоректных данных
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]); //экранирование данных
    }

    public static function count(int $user_id)
    {
        $stmt = self::getPDO()->prepare('SELECT sum(quantity)
                                                FROM user_products
                                                        WHERE user_id = :user_id;');
        $stmt->execute(['user_id' => $user_id]);
        $sum =  $stmt->fetch();
        return $sum;
    }

    public static function updateQuantityAdd(int $productId, int $userId)
    {
        $stmt = self::getPDO()->prepare('UPDATE user_products
                                                             SET quantity = quantity + 1
                                                             WHERE product_id = :productId and user_id = :userId');
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
    }

    public static function updateQuantityMinus(int $productId, int $userId)
    {
        $stmt = self::getPDO()->prepare('UPDATE user_products
                                                             SET quantity = quantity - 1
                                                             WHERE product_id = :productId and user_id = :userId');
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
    }

    public static function getFilterUserProduct(int $userId, int $productId)
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM user_products
                                                             WHERE product_id = :productId 
                                                               and user_id = :userId');
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
        $data = $stmt->fetchAll();
        $userProduct = [];
        foreach ($data as $product){
            $userProduct[] = new UserProduct($product['id'],
                $product['user_id'],
                $product['product_id'],
                $product['quantity']);
        }
        return  $userProduct;
    }
    /*
    public static function getAllOnCart(int $user_id) {

        $stmt = self::getPDO()->prepare('SELECT user_products.id, user_products.user_id, 
                                                            user_products.product_id, 
                                                            title, quantity, price, 
                                                            descr, pictures 
                                                FROM user_products
                                                    JOIN products
                                                        ON user_products.product_id=products.id
                                                            WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $user_id]);
        $data =  $stmt->fetchAll();
        $productCart = [];
        foreach ($data as $product){
            $productCart[] = new UserProduct($product['id'],
                                    $product['user_id'],
                                    $product['product_id'],
                                    $product['quantity'],
                                    $product['title'],
                                    $product['price'],
                                    $product['descr'],
                                    $product['pictures']);
        }


        return  $productCart;

    }
    */


}