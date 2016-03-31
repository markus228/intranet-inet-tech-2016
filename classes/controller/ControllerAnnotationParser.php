<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 16.01.16
 * Time: 13:54
 */

namespace controller;


use controller\Controller;
use Notoj\Notoj;
use Notoj\ReflectionClass;

/**
 * Class ControllerAnnotationParser
 * @package controller
 *
 * Nutzt den AnnotationParser und stellt dem Framework Informationen über verwendete Annotations zur Verfügung
 */
class ControllerAnnotationParser
{
    /**
     * @var Controller
     */
    private $controller;
    private $method;

    /**
     * @var ReflectionClass
     */
    private $reflectionClass;




    public function __construct(Controller $controller) {
        $this->controller = $controller;
        $this->reflectionClass = new ReflectionClass($this->controller);

    }

    /**
     * Gibt alle Annotations zu der Methode eines Controllers aus
     * @param $method
     * @return \Notoj\Annotation\Annotations
     * @throws \BadMethodCallException
     */
    public function getAnnotationsForMethod($method) {
        if (!$this->reflectionClass->hasMethod($method)) throw new \BadMethodCallException("Method not found!");
        return $this->reflectionClass->getMethod($method)->getAnnotations();
    }

    /**
     * @return array|\Notoj\Annotation\Annotations
     */
    public function getAnnotations() {
        return $this->reflectionClass->getAnnotations();
    }



}