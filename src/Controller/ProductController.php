<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;

class ProductController {
   // private UserProduct $userProduct;

   /* public function __construct() {
        $this->userProduct = new UserProduct();

    }*/

    public function getCatalog() {
        session_start();

        if (isset($_SESSION['id'])) {

            $userId = $_SESSION['id'];
            $products = Product::getAll();
            $count = UserProduct::count($userId);
            require_once './../View/catalog.phtml';

        } else {
            header('location: /registrate');
        }
    }

   /* public function plusProduct() {
        session_start();
        if (isset($_SESSION['id'])) {

            $userId = $_SESSION['id'];
            $productId = (int)$_REQUEST['product-id'];

            if (isset($_POST['plus'])){

                header('location: /catalog' );
            }
        }
    }*/

    public function addProduct() {
        session_start();

        if (isset($_SESSION['id'])){

            if (isset($_SESSION['id'])) {

                $userId = $_SESSION['id'];
                $productId = (int)$_REQUEST['product-id'];
                $quantity = 1; // пока 1

                if (isset($_POST['plus'])){

                    echo "Plus";
                    /*$data = UserProduct::getFilterUserProduct($productId, $userId);
                    if(!empty($data)){
                        UserProduct::updateQuantityAdd($productId, $userId);
                        header('location: /catalog' );
                    } else {

                        $this->userProduct->create($userId, $productId, $quantity);
                        header('location: /catalog' );

                    }*/
                }

                if (isset($_POST['minus'])){
/*
                    $data1 = UserProduct::getFilterUserProduct($productId, $userId);
                    if(!empty($data1)){
                        UserProduct::updateQuantityMinus($productId, $userId);
                        header('location: /catalog' );
                    } else {

                        $this->userProduct->create($userId, $productId, $quantity);
                        header('location: /catalog' );

                    }*/

                }

            } else {
                header('location: /registrate');
            }
        }
    }

    public function getCart() {
        session_start();
        if (isset($_SESSION['id'])) {

            $userId = $_SESSION['id'];
            $products =  UserProduct::getAllOnCart($userId);
            require_once './../View/cart.phtml';
        }
    }
}