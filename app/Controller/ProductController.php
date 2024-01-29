<?php

require_once './../Model/Product.php';
require_once './../Model/UserProduct.php';
class ProductController
{
    private Product $product;
    private UserProduct $userProduct;

    public function __construct()
    {
        $this->product = new Product();
        $this->userProduct = new UserProduct();

    }

    public function getCatalog()
    {
        session_start();

        if (isset($_SESSION['id'])) {


            $products = $this->product->getAll();
            $count = $this->userProduct->count();
            require_once './../View/catalog.phtml';

        } else {
            header('location: /registrate');
        }
    }

    public function addProduct()
    {
        session_start();

        if (isset($_SESSION['id'])){

            if (isset($_SESSION['id'])) {


                $userId = $_SESSION['id'];
                $productId = (int)$_REQUEST['product-id'];
                $quantity = (int)$_REQUEST['quantity'];

                //$userProduct = new UserProduct();
                $this->userProduct->create($userId, $productId, $quantity);

                header('location: /catalog' );

            } else {
                header('location: /registrate');
            }
        }
    }

    public function getCart()
    {
        session_start();
        if (isset($_SESSION['id'])) {

            $userId = $_SESSION['id'];
            $products =  $this->userProduct->getAll($userId);

            require_once './../View/cart.phtml';

        }
    }

    /*
    public function countProduct()
    {
        session_start();
        if (isset($_SESSION['id'])) {

            $count =  $this->userProduct->count();
            require_once './../View/catalog.phtml';

        }
    }
    */

}