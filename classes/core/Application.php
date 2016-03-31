<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 17.01.16
 * Time: 15:43
 */

namespace core;


use Notoj\Notoj;

abstract class Application
{

    private static $applicationRoot;

    public static function init() {
        //ErrorHandler::init();
        self::getApplicationRoot();
        //Notoj::enableCache("cache/test.php");
    }

    public static function getApplicationRoot() {
        if (self::$applicationRoot instanceof ApplicationRoot) return self::$applicationRoot;
        self::$applicationRoot = new ApplicationRoot();
        return self::$applicationRoot;
    }


}