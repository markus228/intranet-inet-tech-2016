<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 29.03.16
 * Time: 19:19
 */

namespace helpers;


abstract class FilterHelper
{
    public static function onlyAlphaNumeric($input) {
        return preg_replace("/[^[:alnum:][:space:]]/u", '', $input);
    }

}