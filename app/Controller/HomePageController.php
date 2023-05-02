<?php

namespace App\Controller;

class HomePageController
{
    public static function view()
    {
        require_once ASSET . '/index.php';
        echo 'HomePageController::view()';
    }
}