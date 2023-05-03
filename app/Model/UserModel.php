<?php

namespace App\Model;

use RedBeanPHP\R;

class UserModel
{
    public static function getAll(): array
    {
        new BaseModel();
        return R::findAll('user');
    }

    public static function getUser(int $id)
    {
        new BaseModel();

        $user = R::load('user', $id);

        if (! $user->email) {
            throw new \Exception(
                'Пользователь с таким $id не найден'
            );
        }

        return $user;
    }

    public static function deleteUser(?int $id): void
    {
        new BaseModel();

        $user = R::load('user', $id);

        if (! $user->email) {
            throw new \Exception(
                'Пользователь с таким $id не найден'
            );
        }

        R::trash($user);
    }

    public static function addUser(
        string $email,
        string $password,
        string $role,
    ): void {
        new BaseModel();

        $user = R::dispense( 'user' );

        $user->email = $email;
        $user->password = $password;
        $user->role = $role;

        if (
            $user->role === 'admin' ||
            $user->role === 'user'
        ) {
            R::store( $user );
        } else {
            throw new \Exception(
                'Неверная роль пользователя'
            );
        }

    }

    public static function updateUser(
        int $id,
        $email = null,
        $password = null,
        $role = null,
    ): void {
        new BaseModel();

        $user = R::load( 'user', $id);

        if (! $user->email) {
            throw new \Exception(
                'Пользователь с таким $id не найден'
            );
        }

        if ($email) {
            $user->email = $email;
        }

        if ($password) {
            $user->password = $password;
        }

        if ($role) {
            if (
                $role === 'admin' ||
                $role === 'user'
            ) {
                $user->role = $role;
            } else {
                throw new \Exception(
                    'Неверная роль пользователя'
                );
            }
        }

        R::store($user);
    }

    public static function isEmail(string $email)
    {
        new BaseModel();

        return ! empty(R::findOne('user', 'email LIKE :email', [':email' => $email]));
    }

    public static function isUser(string $email, string $password)
    {
        new BaseModel();

        $user = R::findOne('user', 'email LIKE :email', [':email' => $email]);

        if (! $user) {
            throw new \Exception(
                'Данный пользователь не найден'
            );
        }

        return password_verify($password , $user->password);
    }

    public static function isRoleAdmin(string $email)
    {
        new BaseModel();

        $user = R::findOne('user', 'email LIKE :email', [':email' => $email]);

        if (! $user) {
            throw new \Exception(
                'Данный пользователь не найден'
            );
        }

        return $user->role === 'admin';
    }

}