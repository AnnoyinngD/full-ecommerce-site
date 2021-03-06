<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitce28d06fac64c107b8c54983527e576b
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitce28d06fac64c107b8c54983527e576b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitce28d06fac64c107b8c54983527e576b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
