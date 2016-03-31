<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 26.12.15
 * Time: 22:11
 */

namespace controller;


use Aura\Session\Exception;
use helpers\ExceptionHelper;
use helpers\HTMLHelper;
use models\FileShare;
use models\PathAuth;
use view\BootstrapView;
use view\DashboardContentView;
use view\FilesView;
use view\PersoenlicheStatusseiteView;
use view\RecentlyChangedFilesView;

/**
 * Class AccountController
 * @package controller
 *
 * Controller für Statusseite
 */
class AccountController extends Controller
{


    /**
     * Generiert die Statusseiten Ansicht
     * @return BootstrapView
     * @AuthRequired
     */
    public function defaultAction()
    {
        $user = $this->router->getApplicationSession()->getUser();
        //if (!$this->router->getSessionSegment()->get("authenticated")) $this->router->redirectTo("?controller=main");

        //Letzte geänderte Dateien...
        $pathAuth = new PathAuth($user);
        $fileShare = new FileShare($pathAuth, $pathAuth->getPaths()[0]);

        $fileShareView = new RecentlyChangedFilesView();
        $fileShareView->setFileShare($fileShare);


        //Statusseite
        $view = new PersoenlicheStatusseiteView($user);
        $view->setRecentlyChangedFilesView($fileShareView);


        $dashboard_content = new DashboardContentView();
        $dashboard_content->setContent($view);
        $dashboard_content->setTitle("Persönliche Statusseite");


        $boot = BootstrapView::getDashboard(MainController::$MAIN_TITLE." Persönliche Statusseite", $dashboard_content);
        $boot->addAdditionalJScript("resources/js/persoenlichestatusseite.js");
        $boot->addAdditionalCSS("resources/css/persoenlichestatusseite.css");
        return $boot;
    }


    /**
     * Bearbeitung von Nutzerdetails
     * @throws \Exception
     * @throws \exceptions\UnauthorizedException
     * @AuthRequired
     */
    public function editAction() {
        if ($this->router->getRequestAnalyzer()->getRequestMethod() != "POST") throw new \Exception("Illegal Request Method!");
        $id = $this->router->getRequestAnalyzer()->getPostRequest()["id"];
        if ($id != $this->router->getApplicationSession()->getUser()->getId()) throw new \Exception("Operation not permitted.");
        $currentUser = $this->router->getApplicationRoot()->getUserDAO()->getUserById($id);


        $post_data = $this->router->getRequestAnalyzer()->getPostRequest();

        /*$currentUser->setVorname(
            $post_data["vorname"]
        );

        $currentUser->setNachname(
            $post_data["nachname"]
        );
        */

        $currentUser->setStrasse(
            $post_data["strasse"]
        );

        $currentUser->setHausnr(
            $post_data["hausnr"]
        );

        $currentUser->setPlz(
            $post_data["plz"]
        );

        $currentUser->setOrt(
            $post_data["ort"]
        );

        /*$currentUser->setTelefonDurchwahl(
           Wird nicht verändert
        );*/

        $currentUser->setTelefonDurchwahl(
            $post_data["telefonDurchwahl"]
        );

        $currentUser->setTelefonMobil(
            $post_data["telefonMobil"]
        );

        $currentUser->setTelefonPrivat(
            $post_data["telefonPrivat"]
        );

        $this->router->getApplicationRoot()->getUserDAO()->editUser($currentUser);

    }

    /**
     * Verarbeitet die Änderung des Passworts
     * @return string
     * @AuthRequired
     */
    public function changepwAction(){
        try {
            if ($this->router->getRequestAnalyzer()->getRequestMethod() != "POST") throw new \Exception("Illegal Request Method!");
            $id = $this->router->getRequestAnalyzer()->getPostRequest()["id"];

            /*
             * Nur der eigene Benutzer kann bearbeitet werden...
             */
            if ($id != $this->router->getApplicationSession()->getUser()->getId()) throw new \Exception("Operation not permitted.");

            $currentUser = $this->router->getApplicationRoot()->getUserDAO()->getUserById($id);
            $post_request = $this->router->getRequestAnalyzer()->getPostRequest();

            /*
             * Benutzer authentifizieren...
             */
            $currentPassword = $post_request["currentPassword"];
            $this->router->getApplicationRoot()->getUserDAO()->authenticate($currentUser->getUsername(), $currentPassword);


            $newPassword= $post_request["newPassword"];
            $newPasswordRepeated = $post_request["newPasswordRepeated"];

            if ($newPassword != $newPasswordRepeated) {
                throw new \Exception("Passwörter stimmen nicht überein");
            }

            $this->router->getApplicationRoot()->getUserDAO()->editUser($currentUser, $newPassword);


            return json_encode(
                array(
                    "status" => "success"
                )
            );

        } catch(\Exception $e) {
            header("HTTP/1.1 500 Internal Server Error");
            return json_encode(
                array(
                    "status" => "error",
                    "exception" => ExceptionHelper::exceptionToArrayShortened($e)
                )
            );
        }
    }


    /**
     * Leitet nicht untersützte Actions um
     * @return BootstrapView
     * @AuthRequired
     */
    public function unsupportedAction()
    {
        return $this->defaultAction();
    }
}