<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;
use Service\SessionAuthenticationService;

class ProductController
{
    private SessionAuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new SessionAuthenticationService();
    }

    public function getCatalog():void
    {
        session_start();

        if (isset($_SESSION['id'])) {

            $userId = $_SESSION['id'];
            $products = Product::getAll();
            $count = UserProduct::getCount($userId);
            require_once './../View/catalog.phtml';

        } else  {
            header('location: /registrate');
        }
    }
    public function plusProduct():void
    {
        session_start();

        if (isset($_SESSION['id'])) {


            $userId = $_SESSION['id'];
            $productId = (int)$_REQUEST['product-id'];
            $quantity = 1;

            if (isset($_POST['plus'])) {
                $data = UserProduct::getFilterUserProduct($userId, $productId);

                if(!empty($data)) {
                    UserProduct::updateQuantityAdd($productId, $userId);
                    header('location: /catalog' );
                } else {
                    UserProduct::create($userId, $productId, $quantity);
                    header('location: /catalog' );
                }

                header('location: /catalog' );
            } else {
                echo 'Error';
            }
        } else {
            header('location: /registrate');
        }
    }

   public function minusProduct():void
   {
        session_start();
        if (isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];
            $productId = (int)$_REQUEST['product-id'];

            if (isset($_POST['minus'])) {
                $data = UserProduct::getFilterUserProduct($userId, $productId);
                if(!empty($data)) {
                    UserProduct::updateQuantityMinus($productId, $userId);
                    header('location: /catalog' );
                } else {
                    header('location: /catalog' );
                }
            }
        } else
        {
            header('location: /registrate');
        }
    }

    public function getCart():void
    {
        session_start();
        if (isset($_SESSION['id'])) {

            $userId = $_SESSION['id'];
            $products =  Product::getAllByUserId($userId);
            $userProducts = UserProduct::getAllByUserIdAndProductIds($userId);
            require_once './../View/cart.phtml';
        }
    }
}