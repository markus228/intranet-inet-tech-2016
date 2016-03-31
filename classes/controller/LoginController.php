<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 28.12.15
 * Time: 17:04
 */

namespace controller;


use controller\architecture\Authenticator;
use controller\Controller;
use exceptions\UnauthorizedException;
use helpers\BootstrapAlert;
use view\BootstrapView;
use view\DashboardContentView;
use view\LoginView;

/**
 * Class LoginController
 * @package controller
 *
 * Handelt den Loging des Nutzers
 */
class LoginController extends Controller
{

    //Verhindert Loops
    private static $numberOfLoginsInCurrentRequest = 0;

    /**
     * @return BootstrapView
     * @LogInNotPermitted
     */
    public function promptAction() {
        if ($this->router->getRequestAnalyzer()->getRequestMethod() == "POST" && self::$numberOfLoginsInCurrentRequest == 0) {
            $user = $this->router->getRequestAnalyzer()->getPostRequest()["user"];
            $password = $this->router->getRequestAnalyzer()->getPostRequest()["password"];
            self::$numberOfLoginsInCurrentRequest++;
            try {
                $userObject = $this->router->getApplicationRoot()->getUserDAO()->getUserByUsername($user);
                $this->router->getApplicationRoot()->getAuthenticator()->authenticate($user, $password);
                $this->router->getApplicationSession()->setUser($userObject);
            } catch (UnauthorizedException $e) {
                $this->router->getApplicationRoot()->getAlertStack()->addAlert(BootstrapAlert::DANGER("Login fehlgeschlagen."));
            }
            $this->router->rewindAndRestartRouting();
        } else {
            $view = new LoginView();
            $view->setHeaderText("Awesome Inc.");
            $view->setBadge("Intranet");
            $view->setAlerts(
                $this->router->getApplicationRoot()
                    ->getAlertStack()
                    ->getAlerts()
            );

            return BootstrapView::getLoginPage("", $view);
        }
    }


    public function authenticateAction() {
        return;
    }

    /**
     * @AuthRequired
     */
    public function logoutAction() {
        $this->router->destroySession();
        $this->router->redirectTo("main");
    }


    public function defaultAction()
    {
        return $this->router->redirectTo("main");
    }

    public function unsupportedAction()
    {

    }
}