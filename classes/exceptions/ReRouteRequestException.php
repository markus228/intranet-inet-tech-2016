<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 26.01.16
 * Time: 21:14
 */

namespace exceptions;


use controller\Controller;

class ReRouteRequestException extends \Exception
{

    private $targetControllerName;
    private $targetActionName;

    public function __construct($controller, $action) {
        $this->targetControllerName = $controller;
        $this->targetActionName = $action;
    }


    public function getTargetControllerName()
    {
        return $this->targetControllerName;
    }


    public function getTargetActionName()
    {
        return $this->targetActionName;
    }


}