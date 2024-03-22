<?php

namespace Controller;

use Core\ViewRenderer;
use Model\Product;
use Model\UserProduct;
use Request\MinusProductRequest;
use Request\PlusProductRequest;
use Service\Autentication\AuthenticationServiceInterface;
use Service\CartService;

class ProductController
{
    private AuthenticationServiceInterface $authenticationService;
    private ViewRenderer $viewRenderer;
    private CartService $cartService;
    public function __construct(AuthenticationServiceInterface $authenticationService,
                                CartService $cartService,
                                ViewRenderer $viewRenderer)
    {
        $this->authenticationService = new $authenticationService;
        $this->cartService = new $cartService;
        $this->viewRenderer = new $viewRenderer();
    }

    public function getCatalog():string
    {
        if(!$this->authenticationService->check()){
            header('location: /login');
        }

        $user = $this->authenticationService->getCurrentUser();
        if(!$user) {
            header('location: /login');
        }

        $userId = $user->getId();
        $products = Product::getAll();
        $count = UserProduct::getCount($userId);

        return $this->viewRenderer->render('catalog.phtml', [
            'user' => $user,
            'products' => $products,
            'count' => $count
        ]);

    }
    public function plusProduct(PlusProductRequest $request):void
    {

        if (!$this->authenticationService->check()) {
            header('location: /registrate');
        }

        $user = $this->authenticationService->getCurrentUser();
        if(!$user) {
            header('location: /login');
        }

        $productId = (int)$request->getId();

        $plus = $request->getPlus();
        if (isset($plus)) {

            $this->cartService->plus($user, $productId);

            header('location: /catalog' );
        } else {
            echo 'Error';
        }
    }

   public function minusProduct(MinusProductRequest $request):void
   {

       if (!$this->authenticationService->check()) {
            header('location: /registrate');
       }

       $user = $this->authenticationService->getCurrentUser();
       if(!$user) {
           header('location: /login');
       }

       $productId = (int)$request->getId();

       $minus = $request->getMinus();
       if (isset($minus)) {
           $this->cartService->minus($user, $productId);

           header('location: /catalog' );

       }
    }

}