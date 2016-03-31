<?php
/**
 * Created by PhpStorm.
 * User: ray
 * Date: 17.03.2016
 * Time: 17:42
 */

namespace controller;


use view\BootstrapView;
use view\DashboardContentView;
use view\FaqView;

/**
 * Class FaqController
 * @package controller
 *
 * Controller für den Abruf der FAQ Seite
 */
class FaqController extends Controller
{

    public function defaultAction()
    {


        $faq = new FaqView();

        $content = new DashboardContentView();
        $content->setTitle("FAQ");
        $content->setContent($faq);

        return BootstrapView::getDashboard("FAQ", $content);
    }

    public function unsupportedAction()
    {

    }
}