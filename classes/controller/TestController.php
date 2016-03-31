<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 31.01.16
 * Time: 14:15
 */

namespace controller;


/**
 * Test Controller to verify routing and rewriting processes.
 *
 *
 * Class TestController
 * @package controller
 */
class TestController extends Controller
{

    public function aAction() {
        return "a";
    }

    public function bAction() {
        return "b";
    }

    public function cAction() {
    }

    public function infinityAction() {
        $this->router->reRouteTo("Test", "Infinity");
    }

    public function errorAction() {
        throw new \Exception("This was not supposed to happen");
    }

    public function defaultAction()
    {
        return "default";
    }

    public function unsupportedAction()
    {
        return "unsupported";
    }
}