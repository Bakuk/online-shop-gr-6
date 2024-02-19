<?php

namespace Service;

use http\Cookie;

class CookieAuthentiocationService
{
    public function check()
    {
        return isset($_COOKIE['user_id']);
    }

    public function setUser(int $user_id):void
    {
        setcookie('user_id', $user_id);

    }
}