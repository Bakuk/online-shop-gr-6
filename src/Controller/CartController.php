<?php

namespace Controller;

use Core\AuthenticationServiceInterface;
use Core\ViewRenderer;
use Model\Product;
use Model\UserProduct;
use Service\CartService;

class CartController
{
    private AuthenticationServiceInterface $authenticationService;
    private CartService $cartService;

    private  ViewRenderer $viewRenderer;

    public function __construct(AuthenticationServiceInterface $authenticationService,
                                CartService $cartService,
                                ViewRenderer $viewRenderer)
    {
        $this->authenticationService = new $authenticationService;
        $this->cartService = new $cartService;
        $this->viewRenderer = new $viewRenderer;
    }

    public function getCart():string
    {

        if (!$this->authenticationService->check()) {
            header('location: /login');
        }

        $user = $this->authenticationService->getCurrentUser();
        if(!$user) {
            header('location: /login');
        }

        $userId = $user->getId();
        $products =  Product::getAllByUserId($userId);
        $userProducts = UserProduct::getAllByUserIdAndProductIds($userId);

        return  $this->viewRenderer->render('cart.phtml',[
            'user' => $user,
            'products' => $products,
            'userProducts' => $userProducts
        ]);

    }

}