<?php

namespace App\Controller;

use App\Model\FileModel;

class FileController
{
    public static function list($dir = FILE_SYSTEM)
    {

        if (
            isset($_GET['id'])
        ) {
            $file = FileModel::getFile($_GET['id']);
            $fileName = $file->name;
            $fileDir = $file->directory;

            if (
                $fileDir &&
                file_exists($dir . "/$fileDir" . "/{$fileName}")
            ) {
                var_dump(stat($dir . "/$fileDir" . "/{$fileName}"));

                return;
            }

            if (file_exists($dir . "/{$fileName}")) {
                var_dump(stat($dir . "/{$fileName}"));

                return;
            } else {
                throw new \Exception(
                    'File с таким $id не найден'
                );
            }
        }

        if ($directory = opendir($dir)) {
            while (($file = readdir($directory)) !== false) {

                if (
                    is_dir($dir . "/{$file}") &&
                    $file != '.' &&
                    $file != '..'
                ) {
                    self::list($dir . "/{$file}");
                }

                if (
                    is_file($dir . "/{$file}") &&
                    $file != '.' &&
                    $file != '..'
                ) {
                    echo $file . "<br>";
                }

            }

            closedir($directory);
        }

    }

    public static function add()
    {

        session_start();

        if (! isset($_SESSION['email'])) {
            echo 'Ввойдите в систему';
            die();
        }

        $fileName = self::uniqueFile();

        while (file_exists(FILE_SYSTEM . "/{$fileName}")) {
            $fileName = self::uniqueFile();
        }

        $email = $_SESSION['email'];

        if (
            isset($_GET['directory']) &&
            is_dir(FILE_SYSTEM . '/' . $_GET['directory'])
        ) {
            fopen(FILE_SYSTEM . '/' . $_GET['directory'] . "/{$fileName}", "w");
            chmod(FILE_SYSTEM . '/' . $_GET['directory'] . "/{$fileName}", 0777);
            FileModel::addFile($fileName, $_GET['directory']);
        } else {
            fopen(FILE_SYSTEM . "/{$fileName}", "w");
            chmod(FILE_SYSTEM . "/{$fileName}", 0777);
            FileModel::addFile($fileName, $email);
        }

    }

    public static function update()
    {

        if (! isset($_GET['id'])) {
            throw new \Exception(
                'Вы не ввели id'
            );
        }

        if (! isset($_GET['rename'])) {
            throw new \Exception(
                'Вы не ввели новое имя'
            );
        }

        $file = FileModel::getFile($_GET['id']);
        $fileName = $file->name;
        $fileDir = $file->directory;

        $newName = $_GET['rename'];

        if (
            $fileDir &&
            file_exists(FILE_SYSTEM . "/$fileDir" . "/{$fileName}")
        ) {
            FileModel::updateFile($_GET['id'], $_GET['rename']);
            rename(FILE_SYSTEM . "/$fileDir" . "/{$fileName}", FILE_SYSTEM . "/$fileDir" . "/$newName");
            echo 'file успешно переименовен';

            return;
        }

        if (file_exists(FILE_SYSTEM . "/{$fileName}")) {
            FileModel::updateFile($_GET['id'], $_GET['rename']);
            rename(FILE_SYSTEM . "/{$fileName}", FILE_SYSTEM . "/$newName");
            echo 'file успешно переименовен';

            return;
        } else {
            throw new \Exception(
                'File не удалось переименовать'
            );
        }

    }

    public static function delete()
    {

        if (! isset($_GET['id'])) {
            throw new \Exception(
                'Вы не ввели id'
            );
        }

        $file = FileModel::getFile($_GET['id']);
        $fileName = $file->name;
        $fileDir = $file->directory;

        if (
            $fileDir &&
            file_exists(FILE_SYSTEM . "/$fileDir" . "/{$fileName}")
        ) {
            FileModel::deleteFile($_GET['id']);
            unlink(FILE_SYSTEM . "/$fileDir" . "/{$fileName}");
            echo 'File успешно удален';

            return;
        }

        if (file_exists(FILE_SYSTEM . "/{$fileName}")) {
            FileModel::deleteFile($_GET['id']);
            unlink(FILE_SYSTEM . "/{$fileName}");
            echo 'File успешно удален';
        } else {
            throw new \Exception(
                'File с таким $id не найден'
            );
        }

    }

    public static function uniqueFile()
    {
        return uniqid(time(), true) . '.txt';
    }

    public static function getShare()
    {

        if (! isset($_GET['id'])) {
            echo 'введите id' . PHP_EOL;
            die();
        }

        $accessUsers = FileModel::getAccessUsers($_GET['id']);
        $users = [];

        if ($accessUsers) {
            $emailUsers = explode(' ', $accessUsers);

            foreach ($emailUsers as $email) {
                $users[] = file_get_contents("http://localhost/user/search?email={$email}");
            }
        }

        var_dump($users);

    }

    public static function addShare()
    {

        if (
            ! isset($_GET['id']) &&
            ! isset($_GET['email'])
        ) {
            echo 'введите id' . PHP_EOL;
            echo 'введите email';
            die();
        }

        $idFile = $_GET['id'];
        $email = $_GET['email'];

        FileModel::addAccessUserToFile($idFile, $email);

    }

    public static function deleteShare()
    {

        if (
            ! isset($_GET['id']) &&
            ! isset($_GET['email'])
        ) {
            echo 'введите id' . PHP_EOL;
            echo 'введите email';
            die();
        }

        $idFile = $_GET['id'];
        $email = $_GET['email'];

        FileModel::removeAccessUserToFile($idFile, $email);

    }

}
