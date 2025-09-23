<?php

final class Constant
{
    const VIEW_DIRECTORY       = '/Views/';
    const MODEL_DIRECTORY      = '/Models/';
    const CORE_DIRECTORY       = '/Core/';
    const CONTROLLER_DIRECTORY = '/Controllers/';
    const EXCEPTION_DIRECTORY = '/Exception/';

    public static function rootDirectory()
    {
        return realpath(__DIR__ . '/../');
    }

    public static function coreDirectory()
    {
        return self::rootDirectory() . self::CORE_DIRECTORY;
    }

    public static function exceptionsDirectory()
    {
        return self::rootDirectory() . self::EXCEPTION_DIRECTORY;
    }

    public static function viewDirectory()
    {
        return self::rootDirectory() . self::VIEW_DIRECTORY;
    }

    public static function modelDirectory()
    {
        return self::rootDirectory() . self::MODEL_DIRECTORY;
    }

    public static function controllerDirectory()
    {
        return self::rootDirectory() . self::CONTROLLER_DIRECTORY;
    }
}
