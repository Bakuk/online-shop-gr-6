<?php

namespace Controller\API;

use Model\User;

class UserController
{
    public function index()
    {
        $users = User::all();

        $users = json_encode(['users' => $users], JSON_THROW_ON_ERROR);

        return $users;
    }

    public function create(CreateUserRequest $request)
    {
        $errors = $request->validate();

        if (!empty($errors)) {
            return json_encode($errors);
        }

        $username = $request->getName();
        $email = $request->getEmail();
        $password = $request->getPassword();

        $user = User::create($username, $email, $password);

        return json_encode($user, JSON_THROW_ON_ERROR);

    }
}