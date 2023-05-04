<?php

namespace App\Controller;

use App\Model\DirectoryModel;

class DirectoryController
{

    public static function list()
    {
        if (! isset($_GET['id']))
        {
            throw new \Exception(
                'не введен id'
            );
        }

        $dir = DirectoryModel::getDirectory($_GET['id']);
        $dirName = $dir->name;

        if ($directory = opendir(FILE_SYSTEM . "/$dirName")) {
            while (($file = readdir($directory)) !== false) {
                if (
                    is_file(FILE_SYSTEM . "/$dirName/" . $file) &&
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

        $directoryName = self::uniqueDirectory();

        while (file_exists(FILE_SYSTEM . "/{$directoryName}")) {
            $directoryName = self::uniqueDirectory();
        }

        if (mkdir(FILE_SYSTEM . "/$directoryName")) {
            DirectoryModel::addDirectory($directoryName);

            echo 'Directory успешно создалась';
        }

    }

    public static function delete()
    {

        if (! isset($_GET['id'])) {
            throw new \Exception(
                'Вы не ввели id'
            );
        }

        $file = DirectoryModel::getDirectory($_GET['id']);
        $fileName = $file->name;

        if (file_exists(FILE_SYSTEM . "/{$fileName}")) {
            DirectoryModel::deleteDirectory($_GET['id']);
            rmdir(FILE_SYSTEM . "/{$fileName}");

            echo 'Directory успешно удалена';
        } else {
            throw new \Exception(
                'File с таким $id не найден'
            );
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

        $file = DirectoryModel::getDirectory($_GET['id']);
        $fileName = $file->name;

        $newName = $_GET['rename'];

        if (file_exists(FILE_SYSTEM . "/{$fileName}")) {
            DirectoryModel::updateDirectory($_GET['id'], $_GET['rename']);
            rename(FILE_SYSTEM . "/{$fileName}", FILE_SYSTEM . "/$newName");
            echo 'Directory успешно переименована';
        } else {
            throw new \Exception(
                'File не удалось переименовать'
            );
        }

    }

    public static function uniqueDirectory()
    {
        return uniqid(time(), true);
    }

}