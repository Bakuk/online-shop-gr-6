<?php

use Core\AuthenticationServiceInterface;
use Core\ViewRenderer;

abstract class BaseController
{
    protected AuthenticationServiceInterface $authenticationService;
    protected ViewRenderer $viewRenderer;

    public function __construct(AuthenticationServiceInterface $authenticationService,
                                ViewRenderer $renderer)
    {
        $this->authenticationService = $authenticationService;
        $this->viewRenderer = $renderer;
    }
}
