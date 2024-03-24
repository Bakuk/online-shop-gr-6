<?php

namespace Model;

use Core\src\Model\Model;

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
    public static function create(int $userId, int $productId, int $quantity): void
    {
        $stmt = self::getPDO()->prepare('INSERT INTO user_products (user_id, product_id, quantity) values (:user_id, :product_id, :quantity)'); //защита от некоректных данных
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]); //экранирование данных
    }

    public static function getCount(int $userId): int|null
    {
        $stmt = self::getPDO()->prepare('SELECT sum(quantity) as count
                                                FROM user_products
                                                        WHERE user_id = :user_id;');
        $stmt->execute(['user_id' => $userId]);
        $sum =  $stmt->fetch();

        if (isset($sum['count'])){
            return $sum['count'];
        }

        return null;
    }

    public static function getAllByUserIdAndProductIds(int $userId, ):array
    {
        $sql = <<<SQL
                SELECT * FROM user_products
                    WHERE user_id = :user_id;
        SQL;

        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        $data = $stmt->fetchAll();
        $productsUser = [];
        foreach ($data as $productUser){
            $productsUser[] = new UserProduct($productUser['id'], $productUser['user_id'],
                $productUser['product_id'], $productUser['quantity']);
        }
        return $productsUser;
    }

    public static function updateQuantityAdd(int $productId, int $userId):void
    {
        $stmt = self::getPDO()->prepare('UPDATE user_products
                                                             SET quantity = quantity + 1
                                                             WHERE product_id = :productId and user_id = :userId');
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
    }

    public static function updateQuantityMinus(int $productId, int $userId):void
    {
        $stmt = self::getPDO()->prepare('UPDATE user_products
                                                             SET quantity = quantity - 1
                                                             WHERE product_id = :productId and user_id = :userId');
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
    }



    public static function getFilterUserProduct(int $userId, int $productId):array
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

}