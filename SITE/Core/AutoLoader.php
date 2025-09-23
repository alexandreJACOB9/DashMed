<?php

require 'Constant.php';

final class AutoLoader
{
    public static function loadCore($className)
    {
        $file = Constant::coreDirectory() . "$className.php";
        return static::load($file);
    }

    public static function loadExceptions($className)
    {
        $file = Constant::exceptionsDirectory() . "$className.php";
        return static::load($file);
    }

    public static function loadModel($className)
    {
        $file = Constant::modelDirectory() . "$className.php";
        return static::load($file);
    }

    public static function loadView($className)
    {
        $file = Constant::viewDirectory() . "$className.php";
        return static::load($file);
    }

    public static function loadController($className)
    {
        $file = Constant::controllerDirectory() . "$className.php";
        return static::load($file);
    }

    private static function load($file)
    {
        if (is_readable($file)) {
            require $file;
        }
    }
}

spl_autoload_register('AutoLoader::loadCore');
spl_autoload_register('AutoLoader::loadExceptions');
spl_autoload_register('AutoLoader::loadModel');
spl_autoload_register('AutoLoader::loadView');
spl_autoload_register('AutoLoader::loadController');