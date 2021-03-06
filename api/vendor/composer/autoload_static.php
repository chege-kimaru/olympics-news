<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit08bb7ba55a484ee3f4d3bff8414f8f54
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit08bb7ba55a484ee3f4d3bff8414f8f54::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit08bb7ba55a484ee3f4d3bff8414f8f54::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
