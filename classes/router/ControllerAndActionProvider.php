<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 26.01.16
 * Time: 20:22
 */

namespace router;


interface ControllerAndActionProvider
{
    function getControllerName();
    function getActionName();

}