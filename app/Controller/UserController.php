<?php

namespace App\Controller;

use App\Model\UserModel;
use PHPMailer\PHPMailer\PHPMailer;

class UserController
{
    public static function list(): void
    {
        $users = [];
        $emails = [];

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $users = UserModel::getUser($id);
            $emails = $users->email;
        } else {
            $users = UserModel::getAll();

            foreach ($users as $user) {
                $emails[] = $user->email;
            }
        }

        require_once TEMPLATE . '/user/list.php';
    }

    public static function add(): void
    {

        if (
            ! empty($_POST['email']) &&
            ! empty($_POST['password']) &&
            ! empty($_POST['role'])
        ) {
            UserModel::addUser(
                $_POST['email'],
                password_hash($_POST['password'], PASSWORD_DEFAULT),
                $_POST['role']
            );
        } else {
            throw new \Exception(
                'вы велли не все параметры'
            );
        }

    }

    public static function update(): void
    {
        if (! isset($_GET['id'])) {
            echo 'This user not found';
            die();
        }

        $id = $_GET['id'];

        $_PUT = json_decode(file_get_contents("php://input"), true);

        if (
            ! empty($_PUT['email']) ||
            ! empty($_PUT['password']) ||
            ! empty($_PUT['role'])
        ) {
            if (! empty($_PUT['password'])) {
                $password = password_hash($_PUT['password'], PASSWORD_DEFAULT);
            }

            UserModel::updateUser(
                $id,
                $_PUT['email'] ?? null,
                $password ?? null,
                $_PUT['role'] ?? null
            );
        } else {
            throw new \Exception(
                'Не один из параметров не введен'
            );
        }

    }

    public static function delete(int $id = null): void
    {
        if (! isset($_GET['id'])) {
            echo 'This user not found';
            die();
        }

        $id = $_GET['id'];

        UserModel::deleteUser($id);
    }

    public static function login()
    {

        if (
            ! empty($_GET['password']) &&
            ! empty($_GET['email'])
        ) {
            $password = $_GET['password'];
            $email = $_GET['email'];

            if (UserModel::isUser($email, $password)) {
                session_start();
                $_SESSION['email'] = $email;

                if (! setcookie('session_id', session_id(), time() + 3600, '/')) {
                    echo 'Cookie не установился';
                } else {
                    echo 'Вы успешно вошли';
                }
            } else {
                throw new \Exception(
                    'Данные пользователя введены не верно'
                );
            }
        } else {
            throw new \Exception(
                'Введите данные пользователя'
            );
        }

    }

    public static function logout()
    {
        if (isset($_COOKIE['session_id'])) {
            setcookie('session_id', $_COOKIE['session_id'], time() - 3600, '/');
        }
    }

    public static function resetPassword()
    {

        if (
            ! empty($_GET['email']) &&
            UserModel::isEmail($_GET['email'])
        ) {
            // Генерируем уникальный токен
            $token = bin2hex(random_bytes(32));


            $resetLink = 'http://example.com/reset_password.php?token=' . $token;
            $subject = 'Сброс пароля';
            $message = 'Для сброса пароля перейдите по ссылке: ' . $resetLink;

            $mail = new PHPMailer();
//            $mail->IsSMTP();
//            $mail->Host = "smtp.mail.ru";
//            $mail->SMTPAuth = true;
//            $mail->Username = '*****';
//            $mail->Password = '******';

            $mail->setFrom('skilbox@mail.ru', 'Skillbox');
            $mail->addAddress($_GET['email']);
            $mail->Subject = $subject;
            $mail->Body = $message;

            if ($mail->send()) {
                echo 'Ссылка для сброса пароля отправлена на ваш email';
            } else {
                throw new \Exception(
                    "Не удалось отправить ссылку для сброса на ваш email. Причина ошибки: {$mail->ErrorInfo}"
                );
            }
        } else {
            throw new \Exception(
                'email не верный'
            );
        }

    }

    public static function search()
    {

        if (! isset($_GET['email'])) {
            echo 'вы не ввели email';
            die();
        }

        $user = UserModel::getUserToEmail($_GET['email']);

        echo $user;
    }

}