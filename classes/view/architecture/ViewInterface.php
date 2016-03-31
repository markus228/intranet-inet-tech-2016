<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 20.08.15
 * Time: 16:30
 */

namespace view\architecture;


interface ViewInterface
{
    public function _($key);
    public function __toString();
}