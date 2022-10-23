<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitf89aafacd69ee86b038eb18ff9c49619
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitf89aafacd69ee86b038eb18ff9c49619', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitf89aafacd69ee86b038eb18ff9c49619', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitf89aafacd69ee86b038eb18ff9c49619::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
