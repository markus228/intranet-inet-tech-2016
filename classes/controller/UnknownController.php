<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 24.08.15
 * Time: 16:11
 */

namespace controller;

use controller\Controller;

/**
 * The UnknownController is called when there was no match for a Controller in the Controller name space.
 *
 * Class UnknownController
 * @package controller
 */
class UnknownController extends Controller
{


    public function defaultAction()
    {
        //$this->router->reRouteTo("unknown", "default");
        $this->router->reRouteTo("main", "default");
    }

    public function unsupportedAction()
    {
        //return $this->defaultAction();
    }
}