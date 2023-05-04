<?php

namespace App\Model;

use RedBeanPHP\R;

class FileModel
{

    public static function addFile(
        string $name,
        string $email,
        string $directory = null,
    ): void {
        new BaseModel();

        $file = R::dispense('file');

        $file->name = $name;
        $file->directory = $directory;
        $file->access = $email;

        R::store($file);
    }

    public static function getFile(int $id)
    {

        new BaseModel();

        $file = R::load('file', $id);

        if (! $file->name) {
            throw new \Exception(
                'File с таким $id не найден'
            );
        }

        return $file;

    }

    public static function deleteFile(int $id)
    {

        new BaseModel();

        $file = R::load('file', $id);

        if (! $file->name) {
            throw new \Exception(
                'Пользователь с таким $id не найден'
            );
        }

        R::trash($file);

    }

    public static function updateFile (int $id, string $name): void
    {
        new BaseModel();

        $file = R::load( 'file', $id);

        if (! $file->name) {
            throw new \Exception(
                'Пользователь с таким $id не найден'
            );
        }

        $file->name = $name;

        R::store($file);
    }

    public static function addAccessUserToFile (int $idFile, string $email): void
    {
        new BaseModel();

        $file = R::load('file', $idFile);

        if (! $file->name) {
            throw new \Exception(
                'Пользователь с таким $id не найден'
            );
        }

        $file->access .= " {$email}";

        R::store($file);
    }

    public static function getAccessUsers (int $id)
    {

        new BaseModel();

        $file = R::load('file', $id);

        if (! $file->name) {
            throw new \Exception(
                'Пользователь с таким $id не найден'
            );
        }

        return $file->access;

    }

    public static function removeAccessUserToFile (int $idFile, string $emailUser): void
    {
        new BaseModel();

        $file = R::load('file', $idFile);

        if (! $file->name) {
            throw new \Exception(
                'Пользователь с таким $id не найден'
            );
        }

        $access = $file->access;
        $emails = explode(' ', $access);
        $newEmailsAcces = implode(' ', array_filter($emails, fn ($email) => $emailUser !== $email));

        $file->access = $newEmailsAcces;

        R::store($file);
    }

}
