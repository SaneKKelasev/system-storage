<?php

namespace App\Controller\Admin;

use App\Model\UserModel;
use App\Controller\UserController as User;

class UserController
{
    public static function list()
    {

        session_start();

        if (
            isset($_SESSION['email']) &&
            UserModel::isRoleAdmin($_SESSION['email'])
        ) {
            User::list();
        } else {
            throw new \Exception(
                'Access denied'
            );
        }

    }

    public static function delete(): void
    {

        session_start();

        if (
            isset($_SESSION['email']) &&
            UserModel::isRoleAdmin($_SESSION['email'])
        ) {
            User::delete();
        } else {
            throw new \Exception(
                'Access denied'
            );
        }

    }

    public static function update(): void
    {

        session_start();

        if (
            isset($_SESSION['email']) &&
            UserModel::isRoleAdmin($_SESSION['email'])
        ) {
            User::update();
        } else {
            throw new \Exception(
                'Access denied'
            );
        }

    }
}