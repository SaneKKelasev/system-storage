<?php

namespace App\Model;

use RedBeanPHP\R;

class DirectoryModel
{
    public static function addDirectory(string $name): void
    {
        new BaseModel();

        $directory = R::dispense('directory');

        $directory->name = $name;

        R::store($directory);
    }

    public static function getDirectory(int $id)
    {

        new BaseModel();

        $directory = R::load('directory', $id);

        if (! $directory->name) {
            throw new \Exception(
                'Directory с таким $id не найден'
            );
        }

        return $directory;

    }

    public static function deleteDirectory(int $id)
    {

        new BaseModel();

        $directory = R::load('directory', $id);

        if (! $directory->name) {
            throw new \Exception(
                'Пользователь с таким $id не найден'
            );
        }

        R::trash($directory);

    }

    public static function updateDirectory (int $id, string $name): void
    {
        new BaseModel();

        $directory = R::load( 'directory', $id);

        if (! $directory->name) {
            throw new \Exception(
                'Пользователь с таким $id не найден'
            );
        }

        $directory->name = $name;

        R::store($directory);
    }

}