<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 30.09.15
 * Time: 10:32
 */

namespace helpers;


abstract class Debug
{

    public static function dumpVarsToFileAndDie($vars) {
        ob_start();
        var_dump($vars);
        file_put_contents('/tmp/log.txt', file_get_contents('/tmp/log.txt') . "\n" . ob_get_contents());
        ob_end_clean();
    }

}