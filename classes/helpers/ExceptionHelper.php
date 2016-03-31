<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 09.03.16
 * Time: 14:43
 */

namespace helpers;


abstract class ExceptionHelper
{

    public static function exceptionToArray(\Exception $e) {
        return array(
            "code" => $e->getCode(),
            "file" => $e->getFile(),
            "message" => $e->getMessage(),
            "trace" => $e->getTrace(),
            "line" => $e->getLine(),
            "type" => get_class($e)
        );
    }

    public static function exceptionToArrayShortened(\Exception $e) {
        return array (
            "code" => $e->getCode(),
            "message" => $e->getMessage(),
            "type" => get_class($e)
        );
    }
}