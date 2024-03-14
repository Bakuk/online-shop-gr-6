<?php

namespace Controller;

use Core\ViewRenderer;
use Model\Product;
use Model\UserProduct;
use Request\OrderRequest;
use Service\Autentication\AuthenticationServiceInterface;
use Service\CartService;
use Service\OrderService;

class OrderController
{
    private AuthenticationServiceInterface $authenticationService;
    private OrderService $orderService;

    private ViewRenderer $viewRenderer;
    public function __construct(AuthenticationServiceInterface $authenticationService,
                                OrderService $orderService,
                                ViewRenderer $viewRenderer)
    {
        $this->authenticationService = new $authenticationService;
        $this->orderService = new $orderService;
        $this->viewRenderer = new $viewRenderer;
    }

    public function getOrder():string
    {
        if(!$this->authenticationService->check()){
            header('location: /login');
        }

        $user = $this->authenticationService->getCurrentUser();
        $products =  Product::getAllByUserId($user->getId());
        $userProducts = UserProduct::getAllByUserIdAndProductIds($user->getId());

        if(!$user) {
            header('location: /login');
        }

        return  $this->viewRenderer->render('order.phtml',[
            'user' => $user,
            'products' => $products,
            'userProducts' => $userProducts
        ]);
    }

    public function postOrder(OrderRequest $request)
    {

        $errors = [];

        $errors = $request->validate($_POST);

        if (!$this->authenticationService->check()) {
            header('location: /login');
        }

        $user = $this->authenticationService->getCurrentUser();

        if(!$user) {
            header('location: /login');
        }

        if (empty($errors)) {

            $name = $user->getName();
            $phone = $request->getPhone();
            $address = $request->getAddress();
            $comment = $request->getComment();
            $userId = $user->getId();

            $this->orderService->create($user, $name, $phone, $address, $comment);

            header('location: /catalog');

        }
        else {
            print_r($errors);
            echo "Данные не добавлены";
        }

        return  $this->viewRenderer->render('order.phtml',[
            'user' => $user
        ]);

    }

}