<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit912d4521e7d35ed599d836a42e4757a5
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MenthaWeb\\ProcesswireScssCompiler\\' => 34,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MenthaWeb\\ProcesswireScssCompiler\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit912d4521e7d35ed599d836a42e4757a5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit912d4521e7d35ed599d836a42e4757a5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit912d4521e7d35ed599d836a42e4757a5::$classMap;

        }, null, ClassLoader::class);
    }
}