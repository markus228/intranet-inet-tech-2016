<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 11.01.16
 * Time: 17:43
 */

namespace controller;


class AuthController extends Controller
{

    public function unauthorizedAction() {
        //echo "Nicht authorisiert!";
        //$this->router->redirectTo("?controller=login");
    }

    public function defaultAction()
    {
        return $this->unauthorizedAction();
    }

    public function unsupportedAction()
    {
        return $this->unauthorizedAction();
    }
}