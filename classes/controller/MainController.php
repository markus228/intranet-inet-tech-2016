<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 24.08.15
 * Time: 14:52
 */

namespace controller;


use controller\Controller;
use helpers\BootstrapAlert;
use view\BootstrapView;
use view\DashboardContentView;
use view\MainView;

/**
 * Default Controller.
 * This Controller is called, when there was controller specified in the client's request.
 *
 * Class MainController
 * @package controller
 */
class MainController extends Controller
{

    public static $MAIN_TITLE = "firma-Intranet";

    public function defaultAction()
    {
        return $this->mainPageAction();
    }

    public function mainPageAction() {
        $this->router->reRouteTo("account", "default");
    }

    public function unsupportedAction()
    {
        return "unsupp";
    }
}