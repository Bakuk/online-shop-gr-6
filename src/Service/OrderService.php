<?php

namespace Service;
use Model\Model;
use Model\Product;
use Model\Order;
use Model\UserProduct;
use Model\OrderedProduct;
class OrderService
{
    public function create($user, $name, $phone, $address, $comment)
    {
        $pdo = Model::getPDO();

        $userId = $user->getId();
        $products =  Product::getAllByUserId($user->getId());
        $userProducts = UserProduct::getAllByUserIdAndProductIds($user->getId());

        $pdo->beginTransaction();
        try {

            $orderId = (int)Order::create($userId, $name, $phone, $address, $comment);

            foreach ($userProducts as $userProduct) {
                $product = $products[$userProduct->getId()];
                $productId = $userProduct->getProductId();
                $quantity = $userProduct->getQuantity();
                $total = (float)$product->getPrice() * $userProduct->getQuantity();
                OrderedProduct::create($orderId, $productId, $quantity, $total);
            }

            $pdo->commit();
        } catch (\Throwable $e) {
            // создать файл исключения ошибки 
            $pdo->rollBack();

        }
    }
}