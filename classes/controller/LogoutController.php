<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 31.01.16
 * Time: 15:34
 */

namespace controller;

/**
 * Class LogoutController
 * @package controller
 *
 * Stell Logout Möglichkeit zur Verfügung
 */
class LogoutController extends Controller
{

    public function defaultAction()
    {
        $this->router->reRouteTo("login", "logout");
    }

    public function unsupportedAction()
    {

    }
}