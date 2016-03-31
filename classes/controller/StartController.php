<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 16.03.2016
 * Time: 19:06
 */

namespace controller;


use view\BootstrapView;
use view\DashboardContentView;
use view\StartpageView;

/**
 * Class StartController
 * @package controller
 * Liefert die Relax Seite
 */
class StartController extends Controller
{

    public function defaultAction()
    {
        $content = new DashboardContentView();

        $view = new StartpageView();

        $content->setContent($view);


        //return $view;
        $boot = BootstrapView::getDashboard("Startseite", $content);
        $boot->addAdditionalCSS("resources/css/startpage.css");
        return $boot;
    }

    public function unsupportedAction()
    {

    }
}