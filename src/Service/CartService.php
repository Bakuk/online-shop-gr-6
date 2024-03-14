<?php

namespace Service;

use Model\User;
use Model\UserProduct;
use Model\Product;

class CartService
{
    public function plus(User $user, int $productId)
    {
        $userId = $user->getId();
        $quantity = 1;
        $data = UserProduct::getFilterUserProduct($userId, $productId);

        if(!empty($data)) {
            UserProduct::updateQuantityAdd($productId, $userId);
        } else {
            UserProduct::create($userId, $productId, $quantity);
        }
    }

    public function minus(User $user, int $productId)
    {
        $userId = $user->getId();
        $data = UserProduct::getFilterUserProduct($userId, $productId);
        if(!empty($data)) {

            UserProduct::updateQuantityMinus($productId, $userId);

        }
    }

}