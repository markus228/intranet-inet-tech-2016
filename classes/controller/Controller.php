<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 24.08.15
 * Time: 14:49
 */

namespace controller;



use router\ApplicationRouter;

/**
 * Abstract controller class which all application-specific controllers need to extend.
 *
 * This class provides two abstract methods defaultAction and unsupportedAction, which may be called if there is
 * no action given or if a non existent action was called.
 *
 * Class Controller
 * @package controller
 */
abstract class Controller
{
    protected $router;
    protected $controllerAnnotationParser;

    public function __construct(ApplicationRouter $router) {
        $this->router = $router;
        $this->controllerAnnotationParser = new ControllerAnnotationParser($this);
    }

    /**
     * @return ControllerAnnotationParser
     */
    public function getControllerAnnotationParser()
    {
        return $this->controllerAnnotationParser;
    }


    public abstract function defaultAction();

    public abstract function unsupportedAction();



}