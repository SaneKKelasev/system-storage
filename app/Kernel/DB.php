<?php

namespace App\Kernel;

use RedBeanPHP\R;

class DB
{
    use TSingleton;

    private function __construct()
    {
        $db = require_once CONFIG . '/config_db.php';

        R::setup($db['dsn'], $db['user'],$db['password']);

        if (!R::testConnection()) {
            throw new \Exception('Подключение не удалось', 500);
        }

        R::freeze();
        if (DEBUG) {
            R::debug(true, 3);
        }
    }
}