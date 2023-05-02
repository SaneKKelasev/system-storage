<?php

namespace App\Model;

use App\Kernel\DB;

class BaseModel
{
    public array $attributes = [];

    public function __construct()
    {
        DB::getInstance();
    }

}