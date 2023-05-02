<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite0d5791f92cd0a7d045261c6e063a65d
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Route\\' => 6,
            'RedBeanPHP\\' => 11,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Route\\' => 
        array (
            0 => __DIR__ . '/../..' . '/route',
        ),
        'RedBeanPHP\\' => 
        array (
            0 => __DIR__ . '/..' . '/gabordemooij/redbean/RedBeanPHP',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite0d5791f92cd0a7d045261c6e063a65d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite0d5791f92cd0a7d045261c6e063a65d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite0d5791f92cd0a7d045261c6e063a65d::$classMap;

        }, null, ClassLoader::class);
    }
}
