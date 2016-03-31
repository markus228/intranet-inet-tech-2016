<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 09.03.16
 * Time: 15:12
 */

namespace controller;


use helpers\BootstrapAlert;

/**
 * Class StaticController
 * @package controller
 * For Testing Purposes
 */
class StaticController extends Controller
{

    public function getBootstrapAlertDangerAction() {
        $message = $this->router->getRequestAnalyzer()->getGetRequest()["msg"];
        return BootstrapAlert::DANGER($message);
    }

    public function defaultAction()
    {

    }

    public function unsupportedAction()
    {

    }
}