<?php

const DEBUG = 1;
define("ROOT", dirname(__DIR__));
define("TEMPLATE", ROOT . '/template');
define("FILE_SYSTEM", ROOT . '/file_system');
define("WWW", ROOT . '/public');
define("ASSET", ROOT . '/asset');
define("APP", ROOT . '/app');
define("MODEL", ROOT . '/app/model');
define("CACHE", ROOT . '/tmp/cache');
define("LOGS", ROOT . '/tmp/logs');
define("CONFIG", ROOT . '/config');

require_once ROOT . '/vendor/autoload.php';
